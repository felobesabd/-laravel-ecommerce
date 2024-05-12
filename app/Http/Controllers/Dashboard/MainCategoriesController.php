<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use DB;

class MainCategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::with('_parent')->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.category.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::select('id', 'parent_id')->get();
        return view('dashboard.category.create', compact('categories'));
    }

    public function store(MainCategoryRequest $request)
    {

            DB::beginTransaction();

            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else {
                $request->request->add(['is_active' => 1]);
            }

            $category = Category::create($request->except('_token'));

            // save name
            $category->name = $request->name;
            $category->save();

            DB::commit();
             return redirect()->route('admin.maincategories.create')->with(['success' => 'Created successfully']);
    }

    public function edit($id)
    {
        //get specific categories and its translations
        $category = Category::orderBy('id', 'DESC')->find($id);

        if (!$category) {
            return redirect()->route('admin.maincategories')->with(['error' => 'this category not found']);
        }

        return view('dashboard.category.edit', compact('category'));
    }

    public function update($id, MainCategoryRequest $request)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return redirect()->route('admin.maincategories')->with(['error' => 'this category not found']);
            }

            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else {
                $request->request->add(['is_active' => 1]);
            }

            unset($request['id']);
            $category->update($request->all());
            // save name
            $category->name = $request->name;
            $category->save();

            return redirect()->route('admin.maincategories')->with(['success' => 'Updated successfully']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.maincategories')->with(['error' => 'Updated failed']);
        }
    }

    public function delete($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return redirect()->route('admin.maincategories')->with(['error' => 'this category not found']);
            }

            $category->delete();

            return redirect()->route('admin.maincategories')->with(['success' => 'Updated successfully']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.maincategories')->with(['error' => 'Updated failed']);
        }
    }

}

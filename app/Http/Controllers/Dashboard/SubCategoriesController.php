<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use DB;

class SubCategoriesController extends Controller
{
    public function index()
    {
        $subcategories = Category::child()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.subcategory.index', compact('subcategories'));
    }

    public function create()
    {
        $subcategories = Category::select('id', 'parent_id')->get();
        return view('dashboard.subcategory.create', compact('subcategories'));
    }

    public function store(SubCategoryRequest $request)
    {
        try {
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
             return redirect()->route('admin.subcategories.create')->with(['success' => 'Created successfully']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.subcategories.create')->with(['error' => 'Created failed']);
        }
    }

    public function edit($id)
    {
        //get specific categories and its translations
        $category = Category::orderBy('id', 'DESC')->find($id);

        if (!$category) {
            return redirect()->route('admin.subcategories')->with(['error' => 'this category not found']);
        }

        $subcategories = Category::select('id', 'parent_id')->get();

        return view('dashboard.subcategory.edit', compact('category', 'subcategories'));
    }

    public function update($id, MainCategoryRequest $request)
    {
        try {
            $subcategory = Category::find($id);
            if (!$subcategory) {
                return redirect()->route('admin.subcategories')->with(['error' => 'this category not found']);
            }

            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else {
                $request->request->add(['is_active' => 1]);
            }

            unset($request['id']);
            $subcategory->update($request->all());
            // save name
            $subcategory->name = $request->name;
            $subcategory->save();

            return redirect()->route('admin.subcategories')->with(['success' => 'Updated successfully']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.subcategories')->with(['error' => 'Updated failed']);
        }
    }

    public function delete($id)
    {
        try {
            $subcategory = Category::find($id);
            if (!$subcategory) {
                return redirect()->route('admin.subcategories')->with(['error' => 'this category not found']);
            }

            $subcategory->delete();

            return redirect()->route('admin.subcategories')->with(['success' => 'Updated successfully']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.maincategories')->with(['error' => 'Updated failed']);
        }
    }

}

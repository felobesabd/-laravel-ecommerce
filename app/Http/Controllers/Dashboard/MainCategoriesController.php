<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class MainCategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::parent()->paginate(PAGINATION_COUNT);
        return view('dashboard.category.index', compact('categories'));
    }

    public function edit($id)
    {
        //get specific categories and its translations
        $category = Category::find($id);

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

}

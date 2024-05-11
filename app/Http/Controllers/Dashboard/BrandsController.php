<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use DB;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.brand.index', compact('brands'));
    }

    public function create()
    {
        return view('dashboard.brand.create');
    }

    public function store(BrandRequest $request)
    {
        try {
            DB::beginTransaction();

            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else {
                $request->request->add(['is_active' => 1]);
            }

            $fileName = '';
            if ($request->has('photo')) {
                $fileName = uploadImage('brand', $request->photo);
            }

            $brand = Brand::create($request->except('_token', 'photo'));

            //save translations
            $brand->name = $request->name;
            $brand->photo = $fileName;

            $brand->save();

            DB::commit();
            return redirect()->route('admin.brands.create')->with(['success' => 'Created successfully']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.brands.create')->with(['error' => 'Created failed']);
        }
    }

    public function edit($id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return redirect()->route('admin.brands')->with(['error' => 'this brand not found']);
        }

        return view('dashboard.brand.edit', compact('brand'));
    }

    public function update($id, BrandRequest $request)
    {
        try {
            $brand = Brand::find($id);
            if (!$brand) {
                return redirect()->route('admin.brands')->with(['error' => 'this brand not found']);
            }

            DB::beginTransaction();
            if ($request->has('photo')) {
                $fileName = uploadImage('brand', $request->photo);
                Brand::where('id', $id)->update(['photo' => $fileName]);
            }

            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else {
                $request->request->add(['is_active' => 1]);
            }

            $brand->update($request->except('_token', 'id', 'photo'));
            // save name
            $brand->name = $request->name;
            $brand->save();

            DB::commit();
            return redirect()->route('admin.brands')->with(['success' => 'Updated successfully']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.brands')->with(['error' => 'Updated failed']);
        }
    }

    public function delete($id)
    {
        try {
            $brand = Brand::find($id);
            if (!$brand) {
                return redirect()->route('admin.brands')->with(['error' => 'this category not found']);
            }

            $brand->delete();
            return redirect()->route('admin.brands')->with(['success' => 'Deleted successfully']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.brands')->with(['error' => 'Deleted failed']);
        }
    }
}

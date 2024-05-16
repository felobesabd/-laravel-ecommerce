<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class AttributesController extends Controller
{
    public function index()
    {
        $attributes = Attribute::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('dashboard.attributes.create');
    }

    public function store(AttributeRequest $request)
    {
        try {
            DB::beginTransaction();
            $attribute = Attribute::create([]);

            //save translations
            $attribute->name = $request->name;
            $attribute->save();

            DB::commit();
            return redirect()->route('admin.attributes.create')->with(['success' => 'Created successfully']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.attributes.create')->with(['error' => 'Created failed']);
        }
    }

    public function edit($id)
    {
        $attribute = Attribute::find($id);

        if (!$attribute) {
            return redirect()->route('admin.attributes')->with(['error' => 'this brand not found']);
        }

        return view('dashboard.attributes.edit', compact('attribute'));
    }

    public function update($id, AttributeRequest $request)
    {
        try {
            $attribute = Attribute::find($id);

            // save name
            $attribute->name = $request->name;
            $attribute->save();

            DB::commit();
            return redirect()->route('admin.attributes')->with(['success' => 'Updated successfully']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.attributes')->with(['error' => 'Updated failed']);
        }
    }

//    public function delete($id)
//    {
//        try {
//            $brand = Brand::find($id);
//            if (!$brand) {
//                return redirect()->route('admin.brands')->with(['error' => 'this category not found']);
//            }
//
//            $brand->delete();
//            return redirect()->route('admin.brands')->with(['success' => 'Deleted successfully']);
//        } catch (\Exception $ex) {
//            return redirect()->route('admin.brands')->with(['error' => 'Deleted failed']);
//        }
//    }
}

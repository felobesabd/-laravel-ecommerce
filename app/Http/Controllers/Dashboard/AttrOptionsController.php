<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Http\Requests\AttrOptionRequest;
use App\Models\Attribute;
use App\Models\AttrOption;
use App\Models\Product;
use Illuminate\Http\Request;
use DB;

class AttrOptionsController extends Controller
{
    public function index()
    {
         $options = AttrOption::with(
            [
                'product' => function($prod) {
                    $prod->select('id');
                },
                'attribute' => function($attr) {
                    $attr->select('id');
                }
            ])->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);

        return view('dashboard.attrOption.index', compact('options'));
    }

    public function create()
    {
        $products = Product::select('id')->get();
        $attributes = Attribute::select('id')->get();
        return view('dashboard.attrOption.create', compact('products', 'attributes'));
    }

    public function store(AttrOptionRequest $request)
    {
        try {
            DB::beginTransaction();
            $options = AttrOption::create($request->except('_token'));

            //save translations
            $options->name = $request->name;
            $options->save();

            DB::commit();
            return redirect()->route('admin.attr_options.create')->with(['success' => 'Created successfully']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.attr_options.create')->with(['error' => 'Created failed']);
        }
    }

    public function edit($id)
    {
        $data = [];
        $data['option'] = AttrOption::find($id);

        if (!$data['option']) {
            return redirect()->route('admin.attr_options')->with(['error' => 'this brand not found']);
        }

        $data['products'] = Product::active()->select('id')->get();
        $data['attributes'] = Attribute::select('id')->get();

        return view('dashboard.attrOption.edit', $data);
    }

    public function update($id, AttrOptionRequest $request)
    {
        try {
            $option = AttrOption::find($id);

            if (!$option) {
                return redirect()->route('admin.attr_options')->with(['error' => 'this brand not found']);
            }

            $option->update($request->except('_token', 'id'));

            // save name
            $option->name = $request->name;
            $option->save();

            DB::commit();
            return redirect()->route('admin.attr_options')->with(['success' => 'Updated successfully']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.attr_options')->with(['error' => 'Updated failed']);
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

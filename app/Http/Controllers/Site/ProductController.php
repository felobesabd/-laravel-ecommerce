<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProductDetails($slug)
    {
        $data = [];
        $data['product'] = Product::where('slug', $slug)->first();

        $product_id = $data['product']->id;
        $products_categories_ids = $data['product']->categories->pluck('id');


        $data['product_attributes'] =  Attribute::whereHas('attrOptions' , function ($q) use($product_id){
            $q->whereHas('product', function ($qq) use($product_id) {
                $qq->where('product_id', $product_id);
            });
        })->get();

        $data['related_products'] = Product::whereHas('categories',function ($cat) use($products_categories_ids){
            $cat->whereIn('categories.id', $products_categories_ids);
        })->limit(20)->latest()->get();

        return view('front.products-details', $data);
    }
}

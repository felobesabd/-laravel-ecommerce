<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralProductRequest;
use App\Http\Requests\ProductImagesRequest;
use App\Http\Requests\ProductPricesRequest;
use App\Http\Requests\ProductStockRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Tag;
use DB;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::select('id', 'price', 'slug', 'is_active', 'qty', 'in_stock')->paginate(PAGINATION_COUNT);

        return view('dashboard.product.index', compact('products'));
    }

    public function create()
    {
        $data = [];
        $data['brands'] = Brand::where('is_active', 1)->select('id')->get();
        $data['categories'] = Category::where('is_active', 1)->select('id')->get();
        $data['tags'] = Tag::select('id')->get();

        return view('dashboard.product.general.create', $data);
    }

    public function store(GeneralProductRequest $request)
    {
        DB::beginTransaction();

        if (!$request->has('is_active')) {
            $request->request->add(['is_active' => 0]);
        } else {
            $request->request->add(['is_active' => 1]);
        }

        $product = Product::create([
            'slug' => $request->slug,
            'brand_id' => $request->brand_id,
            'is_active' => $request->is_active,
        ]);

        // save translation
        $product->name = $request->name;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->save();

        // save relations (categories & tags)
        $product->categories()->attach($request->categories);
        $product->tags()->attach($request->tags);

        DB::commit();
    }

    public function getPrice($product_id)
    {
        $product = Product::find($product_id);
        return view('dashboard.product.price.create', compact('product'))->with('id', $product_id);
    }

    public function saveProductPrice(ProductPricesRequest $request)
    {
        try {
            Product::whereId($request-> product_id)-> update($request->except('_token', 'product_id') );
            return redirect()->route('admin.products')->with(['success' => 'Created Prices Success']);
        } catch(\Exception $ex) {
            return redirect()->route('admin.products')->with(['success' => 'Created Prices Failed']);
        }
    }

    public function getStock($product_id)
    {
        return view('dashboard.product.stock.create')->with('id', $product_id);
    }

    public function saveProductStock(ProductStockRequest $request)
    {
        try {
            Product::whereId($request-> product_id)-> update($request->except('_token', 'product_id') );
            return redirect()->route('admin.products')->with(['success' => 'Created Stock Success']);
        } catch(\Exception $ex) {
            return redirect()->route('admin.products')->with(['success' => 'Created Stock Failed']);
        }
    }

    public function addImages($product_id)
    {
        return view('dashboard.product.images.create')->with('id', $product_id);
    }

    public function saveProductImages(Request $request)
    {
        $file = $request->file('dzfile');
        $fileName = uploadImage('product', $file);

        return response()->json([
            'name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function saveProductImagesDB(ProductImagesRequest $request)
    {
        try {
            if ($request->has('document') && count($request->document) > 0) {
                foreach ($request->document as $image) {
                    Image::create([
                        'product_id' => $request-> product_id,
                        'photo' => $image,
                    ]);
                }
            }
            return redirect()->route('admin.products')->with(['success' => 'Upload Images Success']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.products')->with(['success' => 'Upload Images Failed']);
        }
    }
}

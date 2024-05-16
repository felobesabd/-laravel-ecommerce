<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $products = auth()->user()->wishlist()->latest()->get();

        return view('front.wishlist', compact('products'));
    }

    public function store()
    {
        if (!auth()->user()->wishlistHas(request('product_id'))) {
            auth()->user()->wishlist()->attach(request('product_id'));
            return response()->json(['status' => true, 'wishlisted' => true]);
        }

        return response()->json(['status' => true, 'wishlisted' => false]);
    }
}

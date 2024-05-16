<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $data = [];
        $data['sliders'] = Slider::get(['photo']);
        $data['categories'] = Category::parent()->select('id', 'slug')->with(['children' => function($q) {
            $q->select('id', 'parent_id', 'slug');
            $q->with(['children' => function($q2) {
                $q2->select('id', 'parent_id', 'slug');
            }]);
        }])->get();
        return view('front.home', $data);
    }
}

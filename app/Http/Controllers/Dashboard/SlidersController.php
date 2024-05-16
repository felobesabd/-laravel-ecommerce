<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SlidersRequest;
use App\Models\Slider;
use DB;
use Illuminate\Http\Request;

class SlidersController extends Controller
{
    public function create()
    {
        $images = Slider::get(['photo']);
        return view('dashboard.slider.images.create', compact('images'));
    }

    public function saveSliderImages(Request $request)
    {
        $file = $request->file('dzfile');
        $fileName = uploadImage('slider', $file);

        return response()->json([
            'name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function saveSliderImagesDB(SlidersRequest $request)
    {
        try {
            if ($request->has('document') && count($request->document) > 0) {
                foreach ($request->document as $image) {
                    Slider::create([
                        'photo' => $image,
                    ]);
                }
            }
            return redirect()->route('admin.sliders.images')->with(['success' => 'Upload Images Success']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.sliders.images')->with(['success' => 'Upload Images Failed']);
        }
    }
}

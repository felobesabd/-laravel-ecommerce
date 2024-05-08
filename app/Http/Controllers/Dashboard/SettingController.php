<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use DB;

class SettingController extends Controller
{
    public function editShippingMethods($type)
    {
        //free , inner , outer for shipping methods

        if ($type === 'free') {
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();
        } elseif ($type === 'inner') {
            $shippingMethod = Setting::where('key', 'local_label')->first();
        } elseif ($type === 'out') {
            $shippingMethod = Setting::where('key', 'outer_label')->first();
        } else {
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();
        }

        return view('dashboard.settings.shipping.edit', compact('shippingMethod'));
    }

    public function updateShippingMethods(ShippingRequest $request, $id)
    {
        try {
            $shipping_method = Setting::find($id);

            DB::beginTransaction();
            $shipping_method->update(['plain_value' => $request->plain_value]);

            $shipping_method->value = $request->value;
            $shipping_method->save();

            DB::commit();
            return redirect()->back()->with(['success' => 'Updating successfully']);
        } catch (\Exception $exception) {
            return redirect()->back()->with(['error' => 'updating failed']);
            DB::rollback();
        }

    }
}

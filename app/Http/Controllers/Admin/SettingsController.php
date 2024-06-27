<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    public function settings(){
        $setting = Settings::first();
        return view('admin.settings.edit',['setting' => $setting]);
    }

    public function update(Request $request){
        $setting = Settings::first();
        if ($request->hasFile('logo')) {
            $file = $setting->logo;
            $filename = public_path() . '' . $file;
            File::delete($filename);

            $image = $request->file('logo');
            $logo_image_name = $image->hashName();
            $image->move(public_path('/uploads/settings/'), $logo_image_name);

            $logofilePath = "/uploads/settings/" . $logo_image_name;
        }

        if ($request->hasFile('fav_icon')) {
            $file = $setting->fav_icon;
            $filename = public_path() . '' . $file;
            File::delete($filename);

            $image = $request->file('fav_icon');
            $fav_icon_image_name = $image->hashName();
            $image->move(public_path('/uploads/settings/'), $fav_icon_image_name);

            $fav_iconfilePath = "/uploads/settings/" . $fav_icon_image_name;
        }
        if (isset($logofilePath))
            $setting->logo = $logofilePath;
        if (isset($fav_iconfilePath))
            $setting->fav_icon = $fav_iconfilePath;
        $setting->phone = $request->phone;
        $setting->email = $request->email;
        $setting->about_us_ar = $request->about_us_ar;
        $setting->about_us_en = $request->about_us_en;
        $setting->terms_conditions_ar = $request->terms_conditions_ar;
        $setting->terms_conditions_en = $request->terms_conditions_en;
        $setting->policy_ar = $request->policy_ar;
        $setting->policy_en = $request->policy_en;
        $setting->seo_title = $request->seo_title;
        $setting->seo_desc = $request->seo_desc;
        $setting->seo_keyword = $request->seo_keyword;
        $setting->whatsapp = $request->whatsapp;
        $setting->facebook = $request->facebook;
        $setting->instagram = $request->instagram;
        $setting->twitter = $request->twitter;
        $setting->tax = $request->tax;
        $setting->profit_rate = $request->profit_rate;
        $setting->min_project_price = $request->min_project_price;
        $setting->string_text = json_encode($request->string_text);
        $setting->save();

        return redirect()->back()->with('success',__('msg.updated_success'));
    }
}

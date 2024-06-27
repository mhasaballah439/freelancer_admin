<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeSettingsController extends Controller
{
    public function settings(){
        $setting = HomeSetting::first();
        return view('admin.home_settings.edit',['setting' => $setting]);
    }

    public function update(Request $request){
        $setting = HomeSetting::first();

        $setting->app_title_ar = $request->app_title_ar;
        $setting->app_title_en = $request->app_title_en;
        $setting->app_android = $request->app_android;
        $setting->app_ios = $request->app_ios;
        $setting->app_desc_ar = $request->app_desc_ar;
        $setting->app_desc_en = $request->app_desc_en;
        $setting->footer_text_ar = $request->footer_text_ar;
        $setting->footer_text_en = $request->footer_text_en;
        $setting->save();
        if ($request->hasFile('files')) {
            foreach ($request->files as $item) {
                foreach ($item as $file)
                    upload_file($file, 0, 'home_settings', 'App\Models\HomeSetting', $setting->id, 'partners');
            }
        }
        if ($request->hasFile('app_files')) {
            foreach ($request->app_files as $app_item) {
                 upload_file($app_item, 0, 'home_settings', 'App\Models\HomeSetting', $setting->id, 'app_files');
            }
        }
        return redirect()->back()->with('success',__('msg.updated_success'));
    }
}

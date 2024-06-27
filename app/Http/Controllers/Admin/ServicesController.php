<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ServicesController extends Controller
{
    public function index(){
        $services = Service::orderBy('id','DESC')->get();
        return view('admin.services.index',compact('services'));
    }

    public function create(){
        return view('admin.services.add');
    }

    public function store(Request $request){
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = $image->hashName();
            $image->move(public_path('/uploads/slider/'),$image_name);

            $filePath = "/uploads/slider/" . $image_name;
        }
        $service = new Service();
        $service->title_ar = $request->title_ar;
        $service->title_en = $request->title_en;
        $service->desc_ar = $request->desc_ar;
        $service->desc_en = $request->desc_en;
        $service->active = $request->active == 'on' ? 1 : 0;
        if (isset($filePath) && $filePath)
            $service->image = $filePath;
        $service->save();
        if ($request->save == 1)
            return redirect()->route('admin.services.edit', $service->id)->with('success', __('msg.created_success'));
        else
            return redirect()->route('admin.services.index')->with('success', __('msg.created_success'));
    }

    public function edit($id){
        $service = Service::find($id);
        return view('admin.services.edit',compact('service'));
    }

    public function update(Request $request,$id){
        $service = Service::find($id);
        if ($request->hasFile('image')) {
            $file = $service->image;
            $filename = public_path() . '' . $file;
            File::delete($filename);

            $image = $request->file('image');
            $image_name = $image->hashName();
            $image->move(public_path('/uploads/slider/'), $image_name);

            $filePath = "/uploads/slider/" . $image_name;
        }
        $service->title_ar = $request->title_ar;
        $service->title_en = $request->title_en;
        $service->desc_ar = $request->desc_ar;
        $service->desc_en = $request->desc_en;
        $service->active = $request->active == 'on' ? 1 : 0;
        if (isset($filePath) && $filePath)
            $service->image = $filePath;
        $service->save();
        if ($request->save == 1)
            return redirect()->route('admin.services.edit', $service->id)->with('success', __('msg.created_success'));
        else
            return redirect()->route('admin.services.index')->with('success', __('msg.created_success'));
    }

    public function delete(Request $request){
        $service = Service::find($request->id);
        if ($service){
            $file = $service->image;
            $filename = public_path() . '/' . $file;
            File::delete($filename);

            $service->delete();
            return response()->json([
                'status' => true,
                'id' => $request->id,
            ]);
        }
    }

    public function updateStatus(Request $request){
        $service = Service::find($request->id);
        if ($service){
            $service->active = $request->active == 'true' ? 1 : 0;
            $service->save();
            return response()->json([
                'status' => true,
                'id' => $request->id,
            ]);
        }
    }
}

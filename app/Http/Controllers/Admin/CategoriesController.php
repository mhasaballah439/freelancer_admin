<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\CategoryDistrbutors;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoriesController extends Controller
{
    public function index(){
        $categories = Categories::orderBy('id','desc')->get();
        return view('admin.categories.index',compact('categories'));
    }

    public function create(){
        return view('admin.categories.add');
    }

    public function store(Request $request){
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = $image->hashName();
            $image->move(public_path('/uploads/categories/'),$image_name);

            $filePath = "/uploads/categories/" . $image_name;
        }
        $category = new Categories();
        $category->name_ar = $request->name_ar;
        $category->name_en = $request->name_en;
        $category->active = $request->active == 'on' ? 1 : 0;
        if (isset($filePath))
            $category->image = $filePath;
        $category->save();

        if ($request->save == 1)
            return redirect()->route('admin.categories.edit', $category->id)->with('success', __('msg.created_success'));
        else
            return redirect()->route('admin.categories.index')->with('success', __('msg.created_success'));
    }

    public function edit($id){
        $category = Categories::find($id);
        return view('admin.categories.edit',['category' => $category]);
    }

    public function update(Request $request,$id){
        $category = Categories::find($id);
        if ($request->hasFile('image')) {
            $file = $category->image;
            $filename = public_path() . '' . $file;
            File::delete($filename);

            $image = $request->file('image');
            $image_name = $image->hashName();
            $image->move(public_path('/uploads/categories/'), $image_name);

            $filePath = "/uploads/categories/" . $image_name;
        }

        $category->name_ar = $request->name_ar;
        $category->name_en = $request->name_en;
        $category->active = $request->active == 'on' ? 1 : 0;
        if (isset($filePath))
            $category->image = $filePath;
        $category->save();
        if ($request->save == 1)
            return redirect()->route('admin.categories.edit', $category->id)->with('success', __('msg.created_success'));
        else
            return redirect()->route('admin.categories.index')->with('success', __('msg.created_success'));
    }

    public function delete(Request $request){
        $cat = Categories::find($request->id);
        if ($cat){
            $file = $cat->image;
            $filename = public_path() . '/' . $file;
            File::delete($filename);

            $cat->delete();
            return response()->json([
                'status' => true,
                'id' => $request->id,
            ]);
        }
    }

    public function updateStatus(Request $request){
        $cat = Categories::find($request->id);
        if ($cat){
            $cat->active = $request->active == 'true' ? 1 : 0;
            $cat->save();
            return response()->json([
                'status' => true,
                'id' => $request->id,
            ]);
        }
    }

}

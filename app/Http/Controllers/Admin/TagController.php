<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TagController extends Controller
{
    public function index(){
        $tags = Tag::orderBy('id','desc')->get();
        return view('admin.tags.index',compact('tags'));
    }

    public function create(){
        return view('admin.tags.add');
    }

    public function store(Request $request){
        $tag= new Tag();
        $tag->name_ar = $request->name_ar;
        $tag->name_en = $request->name_en;
        $tag->save();
        if ($request->hasFile('image'))
            upload_file($request->image, 0, 'projects', 'App\Models\Tag', $tag->id, null);

        if ($request->save == 1)
            return redirect()->route('admin.tags.edit', $tag->id)->with('success', __('msg.created_success'));
        else
            return redirect()->route('admin.tags.index')->with('success', __('msg.created_success'));
    }

    public function edit($id){
        $tag= Tag::find($id);
        return view('admin.tags.edit',compact('tag'));
    }

    public function update(Request $request,$id){
        $tag= Tag::find($id);
        $tag->name_ar = $request->name_ar;
        $tag->name_en = $request->name_en;
        $tag->save();

        if ($request->hasFile('image')) {
            $old_id = isset($tag->image) ? $tag->image->id : 0;
            upload_file($request->image, $old_id, 'projects', 'App\Models\Tag', $tag->id, null);
        }
        if ($request->save == 1)
            return redirect()->route('admin.tags.edit', $tag->id)->with('success', __('msg.created_success'));
        else
            return redirect()->route('admin.tags.index')->with('success', __('msg.created_success'));
    }

    public function delete(Request $request){
        $tag = Tag::find($request->id);
        if ($tag){
            $tag->delete();
            return response()->json([
                'status' => true,
                'id' => $request->id,
            ]);
        }
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SkillController extends Controller
{
    public function index(){
        $skills = Skill::orderBy('id','desc')->get();
        return view('admin.skills.index',compact('skills'));
    }

    public function create(){
        return view('admin.skills.add');
    }

    public function store(Request $request){
        $skill= new Skill();
        $skill->name_ar = $request->name_ar;
        $skill->name_en = $request->name_en;
        $skill->save();

        if ($request->save == 1)
            return redirect()->route('admin.skills.edit', $skill->id)->with('success', __('msg.created_success'));
        else
            return redirect()->route('admin.skills.index')->with('success', __('msg.created_success'));
    }

    public function edit($id){
        $skill= Skill::find($id);
        return view('admin.skills.edit',compact('skill'));
    }

    public function update(Request $request,$id){
        $skill= Skill::find($id);

        $skill->name_ar = $request->name_ar;
        $skill->name_en = $request->name_en;
        $skill->save();
        if ($request->save == 1)
            return redirect()->route('admin.skills.edit', $skill->id)->with('success', __('msg.created_success'));
        else
            return redirect()->route('admin.skills.index')->with('success', __('msg.created_success'));
    }

    public function delete(Request $request){
        $skill = Skill::find($request->id);
        if ($skill){
            $skill->delete();
            return response()->json([
                'status' => true,
                'id' => $request->id,
            ]);
        }
    }

}

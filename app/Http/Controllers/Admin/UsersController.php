<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Notifacations;
use App\Models\Project;
use App\Models\ProjectRate;
use App\Models\Skill;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $skills = Skill::get();
        $countries = Country::orderBy('id','DESC')->get();
        $tags = Tag::get();
        return view('admin.users.add',compact('skills','countries','tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users'
        ]);
        if ($request->block_ex_date)
            $block_ex_date = Carbon::createFromFormat('d/m/Y',$request->block_ex_date);
        if ($request->birth_date)
            $birth_date_date = Carbon::createFromFormat('d/m/Y',$request->birth_date);
        $user = new User();
        $user->name = $request->name;
        $user->business_name = $request->business_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->status_id = $request->status_id;
        $user->country_id = $request->country_id;
        $user->user_type = $request->user_type;
        $user->id_num = $request->id_num;
        if ($request->birth_date)
            $user->birth_date = $birth_date_date->format('Y-m-d');
        $user->block_ex_date = isset($block_ex_date) && $block_ex_date ? $block_ex_date->format('Y-m-d') : null;
        $user->about_me = $request->about_me;
        if ($request->skills)
            $user->skills = json_encode($request->skills);
        if ($request->tags)
            $user->tags = json_encode($request->tags);
        $user->is_confirm_email = $request->is_confirm_email == 'on' ? 1 : 0;
        $user->is_confirm_phone = $request->is_confirm_phone == 'on' ? 1 : 0;
        $user->is_confirm_id = $request->is_confirm_id == 'on' ? 1 : 0;
        $user->password = bcrypt($request->password);
        $user->save();
        if ($request->hasFile('image'))
            upload_file($request->image,0,'users','App\Models\User',$user->id,'profile_image');
        if ($request->save == 1)
            return redirect()->route('admin.users.edit', $user->id)->with('success', __('msg.created_success'));
        else
            return redirect()->route('admin.users.index')->with('success', __('msg.created_success'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $skills = Skill::get();
        $countries = Country::orderBy('id','DESC')->get();
        $tags = Tag::get();
        return view('admin.users.edit', compact('user','skills','countries','tags'));
    }

    public function show($id){
        $user = User::find($id);
        $projects = Project::where('freelancer_id',$id)->orderBy('id', 'DESC')->get();
        $rates = ProjectRate::where('freelancer_id',$id)->orderBy('id', 'DESC')->get();
        $notifacations = Notifacations::where('user_id',$id)->orderBy('id', 'DESC')->get();
        return view('admin.users.show',compact('user','projects','rates','notifacations'));
    }
    public function update(Request $request, $id)
    {
        if ($request->block_ex_date)
            $block_ex_date = Carbon::createFromFormat('d/m/Y',$request->block_ex_date);
        if ($request->birth_date)
            $birth_date_date = Carbon::createFromFormat('d/m/Y',$request->birth_date);

        $user = User::find($id);

        if ($user) {
            if ($request->name)
                $user->name = $request->name;
            if ($request->business_name)
                $user->business_name = $request->business_name;
            if ($request->phone)
                $user->phone = $request->phone;
            if ($request->email)
                $user->email = $request->email;
            if ($request->id_num)
                $user->id_num = $request->id_num;
            if ($request->birth_date)
                $user->birth_date = $birth_date_date->format('Y-m-d');
            if ($request->user_type)
                $user->user_type = $request->user_type;
            if (isset($block_ex_date) && $block_ex_date)
                $user->block_ex_date = $block_ex_date->format('Y-m-d');
            if ($request->about_me)
                $user->about_me = $request->about_me;
            if ($request->skills)
                $user->skills = json_encode($request->skills);
            if ($request->tags)
                $user->tags = json_encode($request->tags);
            if ($request->country_id)
                $user->country_id = $request->country_id;
            if ($request->password)
                $user->password = bcrypt($request->password);
            $user->is_confirm_email = $request->is_confirm_email == 'on' ? 1 : 0;
            $user->is_confirm_phone = $request->is_confirm_phone == 'on' ? 1 : 0;
            $user->is_confirm_id = $request->is_confirm_id == 'on' ? 1 : 0;
            $user->save();

            if ($request->hasFile('image')) {
                $old_image = isset($user->image) ? $user->image->id : 0;
                upload_file($request->image, $old_image, 'users', 'App\Models\User', $user->id, 'profile_image');
            }
        }
        if ($request->save == 1)
            return redirect()->route('admin.users.edit', $user->id)->with('success', __('msg.created_success'));
        else
            return redirect()->route('admin.users.index')->with('success', __('msg.created_success'));
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        if ($user){
            $user->delete();
            return response()->json([
                'status' => true,
                'id' => $request->id,
            ]);
        }
    }
}

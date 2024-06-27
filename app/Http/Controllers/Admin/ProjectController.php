<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Media;
use App\Models\Notifacations;
use App\Models\Project;
use App\Models\ProjectOffer;
use App\Models\Skill;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::orderBy('id', 'DESC');
        if ($request->category)
            $projects = $projects->where('category_id', $request->category);
        if ($request->business_owner)
            $projects = $projects->where('business_owner_id', $request->business_owner);

        $projects = $projects->get();
        $business_owners = User::where('user_type', 2)->get();
        $categories = Categories::orderBy('id', 'DESC')->get();
        return view('admin.projects.index', compact('projects', 'business_owners', 'categories'));
    }

    public function create()
    {
        $business_owners = User::where('user_type', 2)->get();
        $categories = Categories::orderBy('id', 'DESC')->get();
        $skills = Skill::get();
        $freelancers = User::where('user_type', 1)->get();
        return view('admin.projects.add', compact('business_owners', 'freelancers', 'categories', 'skills'));
    }

    public function store(Request $request)
    {

        $project = new Project();
        $project->business_owner_id = $request->business_owner_id ? $request->business_owner_id : 0;
        $project->freelancer_id = $request->freelancer_id ? $request->freelancer_id : 0;
        $project->category_id = $request->category_id ? $request->category_id : 0;
        $project->status_id = $request->status_id ? $request->status_id : 0;
        $project->work_period_days = $request->work_period_days > 0 ? $request->work_period_days : 0;
        $project->title = $request->title;
        $project->desc = $request->desc;
        $project->from_price = $request->from_price > 0 ? $request->from_price : 0;
        $project->to_price = $request->to_price > 0 ? $request->to_price : 0;
        if ($request->skills)
            $project->skills = json_encode($request->skills);
        $project->save();
        if ($request->hasFile('files')) {
            foreach ($request->files as $file) {
                foreach ($file as $item)
                    upload_file($item, 0, 'projects', 'App\Models\Project', $project->id, null);
            }
        }

        if ($request->save == 1)
            return redirect()->route('admin.projects.edit', $project->id)->with('success', __('msg.created_success'));
        else
            return redirect()->route('admin.projects.index')->with('success', __('msg.created_success'));
    }

    public function edit($id)
    {
        $project = Project::find($id);
        $business_owners = User::where('user_type', 2)->get();
        $freelancers = User::where('user_type', 1)->get();
        $categories = Categories::orderBy('id', 'DESC')->get();
        $skills = Skill::get();
        return view('admin.projects.edit', compact('business_owners','freelancers', 'categories', 'skills', 'project'));
    }
    public function show($id)
    {
        $project = Project::find($id);
        return view('admin.projects.show', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        if ($project) {
            if ($request->business_owner_id)
                $project->business_owner_id = $request->business_owner_id;
            if ($request->freelancer_id)
                $project->freelancer_id = $request->freelancer_id;
            if ($request->category_id)
                $project->category_id = $request->category_id;
            if ($request->status_id)
                $project->status_id = $request->status_id;
            if ($request->work_period_days)
                $project->work_period_days = $request->work_period_days;
            if ($request->title)
                $project->title = $request->title;
            if ($request->desc)
                $project->desc = $request->desc;
            if ($request->from_price)
                $project->from_price = $request->from_price;
            if ($request->to_price)
                $project->to_price = $request->to_price;
                $project->skills = json_encode($request->skills);
            $project->save();
            if ($request->hasFile('files')) {
                foreach ($request->files as $file) {
                    foreach ($file as $item)
                        upload_file($item, 0, 'projects', 'App\Models\Project', $project->id, null);
                }
            }

            $notify = new Notifacations();
            $notify->user_id = $project->freelancer_id;
            $notify->notify = 'تم التحديث على مشروعك من خلال بورد ' ;
            $notify->save();

            $eventName = 'user_notification';
            send_pusher_notification($notify->notify,$eventName,$notify->user_id);
        }
        if ($request->save == 1)
            return redirect()->route('admin.projects.edit', $project->id)->with('success', __('msg.created_success'));
        else
            return redirect()->route('admin.projects.index')->with('success', __('msg.created_success'));
    }

    public function delete(Request $request)
    {
        $project = Project::find($request->id);
        if ($project):
            $project->delete_cause = $request->delete_cause;
            $project->delete();
            return response()->json([
                'status' => true,
                'id' => $request->id,
            ]);
        endif;
    }

    public function deleteOffer(Request $request)
    {
        $project = ProjectOffer::find($request->id);
        if ($project):
            $project->delete();
            return response()->json([
                'status' => true,
                'id' => $request->id,
            ]);
        endif;
    }

    public function deleteFile(Request $request)
    {
        $media_file = Media::find($request->id);
        if ($media_file):
            $file = $media_file->file_path;
            $filename = public_path() . '' . $file;
            File::delete($filename);
            $media_file->delete();
            return response()->json([
                'status' => true,
                'id' => $request->id,
            ]);
        endif;
    }

    public function transactions(Request $request){
        if ($request->get('status'))
        $transactions = Transaction::where('status_id',$request->get('status'))->orderBy('id','DESC')->get();
        else
        $transactions = Transaction::orderBy('id','DESC')->get();
        return view('admin.transactions.index',compact('transactions'));
    }

    public function changeTransactionStatus(Request $request)
    {
        $item = Transaction::find($request->id);
        if ($item):
            $item->status_id = $request->status_id;
            $item->save();

            return response()->json([
                'status' => true,
                'id' => $request->id,
                'status_name' => $item->status_name,
            ]);
        endif;
    }

}

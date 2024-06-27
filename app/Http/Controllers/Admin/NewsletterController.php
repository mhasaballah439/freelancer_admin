<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class NewsletterController extends Controller
{
    public function index(){
        $newsletter = Newsletter::orderBy('id','DESC')->get();
        return view('admin.newsletter.index',compact('newsletter'));
    }

    public function create(){
        return view('admin.newsletter.add');
    }

    public function store(Request $request){
        if ($request->send_date)
            $send_date = Carbon::createFromFormat('d/m/Y',$request->send_date);

        $newsletter = new Newsletter();
        $newsletter->title = $request->title;
        $newsletter->desc = $request->desc;
        if ($request->send_date) {
            $newsletter->send_date = $send_date->format('Y-m-d');
            $newsletter->is_send = $newsletter->send_date > date('Y-m-d') ? 0 : 1;
        }else {
            $newsletter->is_send = 1;
        }
        $newsletter->save();

            return redirect()->route('admin.newsletter.index')->with('success', __('msg.created_success'));
    }

    public function delete(Request $request){
        $newsletter = Newsletter::find($request->id);
        if ($newsletter){
            $newsletter->delete();
            return response()->json([
                'status' => true,
                'id' => $request->id,
            ]);
        }
    }
}

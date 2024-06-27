<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminPermitions;
use App\Models\Links;
use Illuminate\Http\Request;

class AdminPermitionsController extends Controller
{
    public function adminPermitions($id){
        $links = Links::where('parent_id',0)->whereNotIn('id',[3])->get();
        $admin = Admin::find($id);
        return view('admin.admins.permitions',compact('links','admin'));
    }
    public function saveAdminPermissions(Request $request,$id){
        $admin = Admin::find($id);
        if ($request->permission && count($request->permission) > 0){
            if (isset($admin->links_permissions) && count($admin->links_permissions) > 0)
                $admin->links_permissions()->delete();
            foreach ($request->permission as $link){
                $admin_perm = new AdminPermitions;
                $admin_perm->admin_id = $admin->id;
                $admin_perm->link_id = $link;
                $admin_perm->save();
            }
        }

        return redirect()->back();
    }
}

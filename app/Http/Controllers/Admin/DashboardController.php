<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Distributor;
use App\Models\DistributorOrder;
use App\Models\Order;
use App\Models\Project;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function getDashboard(Request $request){
        $freelances = User::where('user_type',1)->count();
        $business_owner = User::where('user_type',2)->count();
        $projects = Project::whereMonth('created_at',date('m'))
        ->whereYear('created_at',date('Y'))->count();
        $montly_sel = [];
        $montly_profit = [];
        for($m = 1; $m <= 12 ; $m++)
        {
            $mm = $m < 10 ? '0'.$m : $m;
            $transactions_list = Transaction::where('type_id',2)->where('is_payment',1)->whereDate('created_at','LIKE',date('Y-'.$mm.'-%'))->get();
            $projects_list = Project::whereIn('status_id',[2,3])->whereDate('created_at','LIKE',date('Y-'.$mm.'-%'))->get();
            $sum = 0;
            $sum_profit = 0;

            foreach($transactions_list as $transaction)
                $sum+= $transaction->price;
            foreach($projects_list as $project)
                $sum_profit+= $project->total_profit;
            $montly_sel[] = ['date' => date('M',strtotime(date('Y-'.$mm.'-01'))),'sum'=> $sum];
            $montly_profit[] = ['date' => date('M',strtotime(date('Y-'.$mm.'-01'))),'sum'=> $sum_profit];
        }
        $transactions = Transaction::count();
        return view('admin.dashboard',[
            'freelances' => $freelances,
            'business_owner' => $business_owner,
            'projects' => $projects,
            'transactions' => $transactions,
            'montly_sel' => $montly_sel,
            'montly_profit' => $montly_profit,
        ]);
    }
}

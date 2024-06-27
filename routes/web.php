<?php

use App\Http\Controllers\Disrtibutor\Auth\LoginController;
use App\Http\Controllers\Disrtibutor\ContactUsController;
use App\Http\Controllers\Disrtibutor\DashboardController;
use App\Http\Controllers\Disrtibutor\DisrtibutorController;
use App\Http\Controllers\Disrtibutor\DistributorOrderController;
use App\Http\Controllers\Disrtibutor\OrderController;
use App\Http\Controllers\Disrtibutor\ProductController;
use App\Http\Controllers\Disrtibutor\UsersController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (){
    return redirect()->route('get.admin.login');
})->name('site.home');
Route::get('/change-local/{lang}',function ($lang){
    if (!in_array($lang, ['en', 'ar'])) {
        abort(404);
    }
    app()->setLocale($lang);
    session()->put('locale',$lang);
    return redirect()->back();
});
Route::get('/clear-cash',function (){
   \Illuminate\Support\Facades\Artisan::call('config:clear');
   \Illuminate\Support\Facades\Artisan::call('route:clear');
   \Illuminate\Support\Facades\Artisan::call('cache:clear');
   \Illuminate\Support\Facades\Artisan::call('view:clear');
   \Illuminate\Support\Facades\Artisan::call('config:clear');
   return 'cleared';
});

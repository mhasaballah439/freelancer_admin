<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\HomeSettingsController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\OnbordingController;
use App\Http\Controllers\Admin\CountriesCitiesController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\vendor\Chatify\MessagesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AdminPermitionsController;


Route::group(['namespace' => 'Admin', 'middleware' => 'auth:admin', 'prefix' => 'admin'], function () {
    Route::get('/dashboard',[DashboardController::class,'getDashboard'])->name('dashboard.index');
    Route::post('/logout',[LoginController::class,'logout'])->name('admin.logout');
    ########################## profile ###############################
    Route::get('/profile',[AdminController::class,'profile'])->name('admin.profile');
    Route::post('/update-profile',[AdminController::class,'updateProfile'])->name('admin.update.profile');
    ####################### admins #########################
    Route::get('/admins',[AdminController::class,'index'])->name('admin.admins.index');
    Route::get('/create-admin',[AdminController::class,'create'])->name('admin.admins.create');
    Route::post('/store-admin',[AdminController::class,'store'])->name('admin.admins.store');
    Route::post('/update-admin/{id}',[AdminController::class,'update'])->name('admin.admins.update');
    Route::get('/edit-admin/{id}',[AdminController::class,'edit'])->name('admin.admins.edit');
    Route::post('/delete-admin',[AdminController::class,'delete'])->name('admin.admins.delete');
    Route::post('/update-admin-status',[AdminController::class,'updateStatus'])->name('admin.admins.update.status');
    Route::post('/store-emp-admin',[AdminController::class,'storeEmployee'])->name('store.emp.admin');
    Route::post('/edit-emp-admin',[AdminController::class,'editEmployee'])->name('edit.emp.admin');
    Route::get('/admin-permissions/{id}',[AdminPermitionsController::class,'adminPermitions'])->name('admin.permissions.index');
    Route::post('/admin-save-permissions/{id}',[AdminPermitionsController::class,'saveAdminPermissions'])->name('admin.save.permissions');
    ####################### slider #########################
    ####################### users #########################
    Route::get('/users',[UsersController::class,'index'])->name('admin.users.index');
    Route::get('/create-user',[UsersController::class,'create'])->name('admin.users.create');
    Route::post('/store-user',[UsersController::class,'store'])->name('admin.users.store');
    Route::get('/edit-user/{id}',[UsersController::class,'edit'])->name('admin.users.edit');
    Route::get('/show-user/{id}',[UsersController::class,'show'])->name('admin.users.show');
    Route::post('/update-user/{id}',[UsersController::class,'update'])->name('admin.users.update');
    Route::post('/delete-user',[UsersController::class,'delete'])->name('admin.users.delete');
    Route::post('/update-user-status',[UsersController::class,'updateStatus'])->name('admin.users.update.status');
    ####################### users #########################
    Route::get('/countries',[CountriesCitiesController::class,'index'])->name('admin.countries.index');
    Route::get('/create-country',[CountriesCitiesController::class,'create'])->name('admin.countries.create');
    Route::post('/store-country',[CountriesCitiesController::class,'store'])->name('admin.countries.store');
    Route::get('/edit-country/{id}',[CountriesCitiesController::class,'edit'])->name('admin.countries.edit');
    Route::post('/update-country/{id}',[CountriesCitiesController::class,'update'])->name('admin.countries.update');
    Route::post('/delete-country',[CountriesCitiesController::class,'delete'])->name('admin.countries.delete');
    ###################### settings ########################
    Route::get('/settings',[SettingsController::class,'settings'])->name('admin.settings.edit');
    Route::post('/setting-update',[SettingsController::class,'update'])->name('admin.settings.update');
    ######################home- settings ########################
    Route::get('/home-settings',[HomeSettingsController::class,'settings'])->name('admin.home_settings.edit');
    Route::post('/home-setting-update',[HomeSettingsController::class,'update'])->name('admin.home_settings.update');
    ####################### categories #########################
    Route::get('/categories',[CategoriesController::class,'index'])->name('admin.categories.index');
    Route::get('/create-category',[CategoriesController::class,'create'])->name('admin.categories.create');
    Route::post('/store-category',[CategoriesController::class,'store'])->name('admin.categories.store');
    Route::get('/edit-category/{id}',[CategoriesController::class,'edit'])->name('admin.categories.edit');
    Route::post('/update-category/{id}',[CategoriesController::class,'update'])->name('admin.categories.update');
    Route::post('/delete-category',[CategoriesController::class,'delete'])->name('admin.categories.delete');
    Route::post('/update-category-status',[CategoriesController::class,'updateStatus'])->name('admin.categories.update.status');
    ######################3 skills ##############################
    Route::get('/skills',[SkillController::class,'index'])->name('admin.skills.index');
    Route::get('/create-skill',[SkillController::class,'create'])->name('admin.skills.create');
    Route::post('/store-skill',[SkillController::class,'store'])->name('admin.skills.store');
    Route::get('/edit-skill/{id}',[SkillController::class,'edit'])->name('admin.skills.edit');
    Route::post('/update-skill/{id}',[SkillController::class,'update'])->name('admin.skills.update');
    Route::post('/delete-skill',[SkillController::class,'delete'])->name('admin.skills.delete');
    ######################3 tags ##############################
    Route::get('/tags',[TagController::class,'index'])->name('admin.tags.index');
    Route::get('/create-tag',[TagController::class,'create'])->name('admin.tags.create');
    Route::post('/store-tag',[TagController::class,'store'])->name('admin.tags.store');
    Route::get('/edit-tag/{id}',[TagController::class,'edit'])->name('admin.tags.edit');
    Route::post('/update-tag/{id}',[TagController::class,'update'])->name('admin.tags.update');
    Route::post('/delete-tag',[TagController::class,'delete'])->name('admin.tags.delete');
    ######################3 projects ##############################
    Route::get('/projects',[ProjectController::class,'index'])->name('admin.projects.index');
    Route::get('/create-project',[ProjectController::class,'create'])->name('admin.projects.create');
    Route::post('/store-project',[ProjectController::class,'store'])->name('admin.projects.store');
    Route::get('/show-project/{id}',[ProjectController::class,'show'])->name('admin.projects.show');
    Route::get('/edit-project/{id}',[ProjectController::class,'edit'])->name('admin.projects.edit');
    Route::post('/update-project/{id}',[ProjectController::class,'update'])->name('admin.projects.update');
    Route::post('/delete-project',[ProjectController::class,'delete'])->name('admin.projects.delete');
    Route::post('/delete-file',[ProjectController::class,'deleteFile'])->name('admin.file.delete');
    Route::post('/delete-project-offer',[ProjectController::class,'deleteOffer'])->name('admin.offer.delete');
    Route::get('/transactions', [ProjectController::class,'transactions'])->name('admin.transactions.index');
    Route::post('/change-transaction-status', [ProjectController::class,'changeTransactionStatus'])->name('admin.change_transaction_status');
    ####################### onbording #########################
    Route::get('/onbording',[OnbordingController::class,'index'])->name('admin.onbording.index');
    Route::get('/create-onbording',[OnbordingController::class,'create'])->name('admin.onbording.create');
    Route::post('/store-onbording',[OnbordingController::class,'store'])->name('admin.onbording.store');
    Route::get('/edit-onbording/{id}',[OnbordingController::class,'edit'])->name('admin.onbording.edit');
    Route::post('/update-onbording/{id}',[OnbordingController::class,'update'])->name('admin.onbording.update');
    Route::post('/delete-onbording',[OnbordingController::class,'delete'])->name('admin.onbording.delete');
    Route::post('/update-onbording-status',[OnbordingController::class,'updateStatus'])->name('admin.onbording.update.status');
    ####################### newsletter #########################
    Route::get('/newsletter',[NewsletterController::class,'index'])->name('admin.newsletter.index');
    Route::get('/create-newsletter',[NewsletterController::class,'create'])->name('admin.newsletter.create');
    Route::post('/store-newsletter',[NewsletterController::class,'store'])->name('admin.newsletter.store');
    Route::post('/delete-newsletter',[NewsletterController::class,'delete'])->name('admin.newsletter.delete');
    ####################### slider #########################
    Route::get('/sliders',[SliderController::class,'index'])->name('admin.sliders.index');
    Route::get('/create-slider',[SliderController::class,'create'])->name('admin.sliders.create');
    Route::post('/store-slider',[SliderController::class,'store'])->name('admin.sliders.store');
    Route::get('/edit-slider/{id}',[SliderController::class,'edit'])->name('admin.sliders.edit');
    Route::post('/update-slider/{id}',[SliderController::class,'update'])->name('admin.sliders.update');
    Route::post('/delete-slider',[SliderController::class,'delete'])->name('admin.sliders.delete');
    Route::post('/update-slider-status',[SliderController::class,'updateStatus'])->name('admin.sliders.update.status');
    ####################### services #########################
    Route::get('/services',[ServicesController::class,'index'])->name('admin.services.index');
    Route::get('/create-service',[ServicesController::class,'create'])->name('admin.services.create');
    Route::post('/store-service',[ServicesController::class,'store'])->name('admin.services.store');
    Route::get('/edit-service/{id}',[ServicesController::class,'edit'])->name('admin.services.edit');
    Route::post('/update-service/{id}',[ServicesController::class,'update'])->name('admin.services.update');
    Route::post('/delete-service',[ServicesController::class,'delete'])->name('admin.services.delete');
    Route::post('/update-service-status',[ServicesController::class,'updateStatus'])->name('admin.services.update.status');
    ############################# chat ####################################
    Route::get('/chat/{id?}/{id2?}',[ChatController::class,'index'])->name('admin.chat.index');
    Route::get('/chat-users',[ChatController::class,'getUsersList'])->name('admin.chat.users');
    Route::get('/chat-user-messages/{id?}/{id2?}',[ChatController::class,'getUserMessages'])->name('admin.chat.user_messages');
    Route::post('/chat-send',[ChatController::class,'sendMessage'])->name('admin.chat.send');
    ###################### contactus ########################
    Route::get('/contact-us',[ContactUsController::class,'index'])->name('admin.contacts.index');
    Route::get('/contact-us/{id}',[ContactUsController::class,'show'])->name('admin.contacts.show');
    Route::post('/update-contact-us/{id}',[ContactUsController::class,'update'])->name('admin.contacts.update');
    Route::post('/delete-contact',[ContactUsController::class,'delete'])->name('admin.contacts.delete');
});
Route::get('admin/login',[LoginController::class,'getLoginForm'])->name('get.admin.login');
Route::post('admin/login',[LoginController::class,'login'])->name('admin.login');

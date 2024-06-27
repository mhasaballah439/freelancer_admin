<?php

use App\Http\Controllers\Admin\Api\AuthApiController;
use App\Http\Controllers\Admin\Api\SystemApiController;
use App\Http\Controllers\vendor\Chatify\Api\MessagesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['namespace' => 'Admin'],function (){
    ################### auth ##############
    Route::post('/login',[AuthApiController::class,'login']);
    Route::post('/register',[AuthApiController::class,'register']);
    ######################################
    Route::get('/in-boarding',[SystemApiController::class,'inBordingData']);
    Route::post('/check-verification-code',[SystemApiController::class,'checkVerificationCode']);
    Route::post('/resend-code',[SystemApiController::class,'resendCode']);
    Route::post('/forget-password',[SystemApiController::class,'forgetPassword']);
    Route::get('/settings',[SystemApiController::class,'settings']);
    ################### projects ################3
    Route::get('/categories',[SystemApiController::class,'categories']);
    Route::post('/projects',[SystemApiController::class,'projects']);
    Route::post('/project-details',[SystemApiController::class,'projectDetails']);
    ############## website ###################
    Route::get('/slider',[SystemApiController::class,'slider']);
    Route::get('/services',[SystemApiController::class,'services']);
    Route::get('/countries',[SystemApiController::class,'countries']);
    Route::get('/home-settings',[SystemApiController::class,'homeSettings']);
    Route::post('/find-user-data',[SystemApiController::class,'findUserData']);
});

Route::group(['middleware' => 'JwtMiddleware' ,'namespace' => 'Admin'],function (){
    Route::get('/user-data',[SystemApiController::class,'getUserData']);
    Route::get('/logout',[AuthApiController::class,'logout']);
    Route::post('/change-password',[SystemApiController::class,'changePassword']);
    Route::post('/update-profile',[SystemApiController::class,'updateProfile']);
    Route::post('/change-user-password',[SystemApiController::class,'changeUserPassword']);

    ##################### contactUs ######################3
    Route::post('/contact-us',[SystemApiController::class,'contactUs']);
    ##################### projects ##################
    Route::post('/freelancer-projects',[SystemApiController::class,'freelancerProjects']);
    Route::post('/business-owner-projects',[SystemApiController::class,'businessOwnerProjects']);
    Route::post('/freelancer-add-offer',[SystemApiController::class,'freelancerAddOffer']);
    Route::post('/freelancer-update-offer',[SystemApiController::class,'freelancerUpdateOffer']);
    Route::get('/freelancer-offers-list',[SystemApiController::class,'freelancerOfferList']);
    Route::post('/accept-offer',[SystemApiController::class,'acceptOffer']);
    Route::post('/delete-offer',[SystemApiController::class,'deleteOffer']);
    Route::post('/create-project',[SystemApiController::class,'createProject']);
    Route::get('/skills',[SystemApiController::class,'skillsList']);
    Route::post('/update-project-status',[SystemApiController::class,'updateProjectStatus']);
    #################### cards ####################
    Route::get('/users-cards',[SystemApiController::class,'usersCards']);
    Route::post('/add-user-card',[SystemApiController::class,'addUserCard']);
    Route::post('/delete-card',[SystemApiController::class,'deleteCard']);
    ################# transactions ###################
    Route::get('/business-owner-transactions',[SystemApiController::class,'businessOwnerTransactions']);
    Route::get('/freelancer-transactions',[SystemApiController::class,'freelancerTransactions']);
    Route::get('/user-notifications',[SystemApiController::class,'userNotifacations']);
    Route::get('/delete-account',[SystemApiController::class,'deleteAccount']);
    Route::post('/rate-freelancer',[SystemApiController::class,'rateFreelancer']);
    Route::post('/delete-file',[SystemApiController::class,'deleteFile']);
    Route::post('/make-transaction',[SystemApiController::class,'makeTransaction']);
    Route::post('/check-order-payment',[SystemApiController::class,'checkOrderPayment']);
    Route::post('/add-portfolio',[SystemApiController::class,'addPortfolio']);
    Route::post('/delete-portfolio',[SystemApiController::class,'deletePortfilo']);
    Route::post('/make-notification-read',[SystemApiController::class,'makeNotifacationRead']);
    ################## chat ###################
    Route::post('/chat/auth', [MessagesController::class,'pusherAuth'])->name('api.pusher.auth');
    Route::post('/send-message', [MessagesController::class,'send'])->name('api.send.message');
    Route::post('/fetch-messages', [MessagesController::class,'fetch'])->name('api.fetch.messages');
    Route::get('/download/{fileName}', [MessagesController::class,'download'])->name('api.'.config('chatify.attachments.download_route_name'));
    Route::post('/make-seen', [MessagesController::class,'seen'])->name('api.messages.seen');
    Route::get('/get-contacts', [MessagesController::class,'getContacts'])->name('api.contacts.get');
    Route::post('/favorite', [MessagesController::class,'favorite'])->name('api.star');
    Route::post('/favorites', [MessagesController::class,'getFavorites'])->name('api.favorites');
    Route::post('/delete-conversation', [MessagesController::class,'deleteConversation'])->name('api.conversation.delete');
    Route::post('/set-active-status', [MessagesController::class,'setActiveStatus'])->name('api.activeStatus.set');


});

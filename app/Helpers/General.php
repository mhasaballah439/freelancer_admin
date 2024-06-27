<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Pusher\Pusher;


function get_default_languages()
{
    return Config::get('app.locale');
}

function admin(){
    return auth()->guard('admin')->user();
}

function user(){
    return auth()->guard('web')->user();
}

function distributor(){
    return auth()->guard('distributor')->user();
}
function upload_file($file,$old_file_id = 0,$folder,$modal,$mediable_id,$type){
    if ($old_file_id && $old_file_id > 0){
        $old_file_id_data = \App\Models\Media::find($old_file_id);
        $oldfilename = public_path() . '' . $old_file_id_data->file_path;
        File::delete($oldfilename);
        $old_file_id_data->delete();
    }

    $image_name = hash('sha256', $file->getClientOriginalName()).''.$file->getClientOriginalName();

    $file->move(public_path('/uploads/'.$folder."/"), $image_name);
    $filePath = "/uploads/".$folder."/". $image_name;
    $media_file = new \App\Models\Media();
    $media_file->mediable_type = $modal;
    $media_file->file_name = $file->getClientOriginalName();
    $media_file->mediable_id = $mediable_id;
    $media_file->file_path = $filePath;
    $media_file->type = $type;
    $media_file->save();

    return $filePath;
}

function upload_profile_file($file,$type,$folder,$modal,$mediable_id){
    $image_name = $file->hashName();
    $file->move(public_path('/uploads/'.$folder."/"), $image_name);
    $filePath = "/uploads/".$folder."/". $image_name;
    $media_file = new \App\Models\Media();
    $media_file->mediable_type = $modal;
    $media_file->file_name = $file->getClientOriginalName();
    $media_file->mediable_id = $mediable_id;
    $media_file->file_path = $filePath;
    $media_file->type = $type;
    $media_file->save();

    return $filePath;
}
function user_data(){
    $user = auth()->user();
    return [
        'id' => $user->id,
        'name' => $user->name,
        'user_name' => $user->user_name ?? '',
        'email' => $user->email,
        'phone' => $user->phone,
        'status_id' => $user->status_id,
        'fcm_token' => $user->fcm_token ?? '',
        'business_name' => $user->business_name ?? '',
        'is_confirm_email' => $user->is_confirm_email,
        'is_confirm_phone' => $user->is_confirm_phone,
        'is_confirm_id' => $user->is_confirm_id,
        'about_me' => $user->about_me ?? '',
        'user_type' => $user->user_type,
        'country_id' => $user->country_id,
        'country_name' => isset($user->country) ? $user->country->name : '',
        'id_num' => $user->id_num,
        'withdrawable_balance' => (float)$user->withdrawable_balance,
        'pending_balance' => (float)$user->pending_balance,
        'birth_date' => $user->birth_date ? date('d/m/Y',strtotime($user->birth_date)) : '',
        'social_token' => $user->social_token ?? '',
        'skills' => $user->skills ? json_decode($user->skills) : [],
        'tags' => $user->tags ? json_decode($user->tags) : [],
        'fav_categories' => $user->fav_categories ? json_decode($user->fav_categories) : [],
        'image' => isset($user->image) ? asset('public'.$user->image->file_path) : '',
    ];
}
function send_pusher_notification($message,$eventName,$user_id,$type_id,$project_id,$contact_id = 0){

    $channelName ='notification.'.$user_id;

    $options = [
        'cluster' => env('PUSHER_APP_CLUSTER'),
        'useTLS' => true,
    ];

    $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), $options);

    $pusher->trigger($channelName, $eventName, ['message' => $message,'user_id' => $user_id]);
}


function sendToFcm($fcm, $text, $title)
{

    $header = [];
    $header[] = 'Content-Type: application/json ';
    $header[] = 'Authorization: key=AAAA1Gx2kz4:APA91bF1X4aVd4NgSq-yvmMzKwUWVdzyC9aLuHEteiwlDyZd82KBJvFus9E7CDDn9URil6cK17JpHJoM6SWh3vjhAY8-qI6X_WAYLl7VxHQKS1OZYwIrRGGgihAu897gKNy2ge40yvdC';

    $data = [
        "to" => $fcm,
        "notification" => [
            "sound" => "default",
            "body" => $text,
            "title" => $title,
            "content_available" => true,
            "priority" => "high"
        ],
        "data" => [
            "sound" => "default",
            "body" => $text,
            "title" => $title,
            "content_available" => true,
            "priority" => "high"
        ]
    ];

    $url = 'https://fcm.googleapis.com/fcm/send';

    $data = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;

}

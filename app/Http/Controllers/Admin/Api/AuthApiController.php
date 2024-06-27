<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class AuthApiController extends Controller
{
    use ApiTrait;

    var $lang;

    ################ auth #############
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->lang = \request()->get('lang') ? \request()->get('lang') : 'ar';
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if ($request->social_token) {
            $user = User::where('social_token', $request->social_token)->first();
            if (!$user) {
                $user = User::where('email', $request->email)->first();
                if (!$user)
                    $user = new User();
                if ($request->name)
                    $user->name = $request->name;
                if ($request->name)
                    $user->user_name = $request->name;
                $user->email = $request->email;
                $user->social_token = $request->social_token;
                if ($request->fcm_token)
                    $user->fcm_token = $request->fcm_token;
                if ($user->user_type > 0)
                    $user->user_type = 1;
                $user->status_id = 1;
                $user->password = rand(1111111,9999999);
                $user->save();
            }else{
                if ($request->name)
                    $user->name = $request->name;
                if ($request->name)
                    $user->user_name = $request->name;
                $user->social_token = $request->social_token;
                if ($request->fcm_token)
                    $user->fcm_token = $request->fcm_token;
                $user->save();
            }
        }
        else {
            $user = User::where('email', $request->email)->first();

            if (!$user)
                return $this->errorResponse(__('msg.user_not_found', [], $this->lang), 401);

            if (!Hash::check($request->password, $user->password))
                return $this->errorResponse(__('msg.password_error', [], $this->lang), 401);

            if ($user->status_id == 3)
                return $this->errorResponse(__('msg.user_not_active', [], $this->lang), 401);

            if ($user->status_id == 2 && date('Y-m-d') < $user->block_ex_date)
                return $this->errorResponse(__('msg.user_suspend', [], $this->lang), 401);
            if ($request->fcm_token)
                $user->fcm_token = $request->fcm_token;
            if ($request->social_token)
                $user->social_token = $request->social_token;

            $user->save();
        }


        $token = auth()->login($user);

        $data = [
            'token' => $token,
            'user' => user_data()
        ];
        return $this->dataResponse(__('msg.account_login_successfully',[],$this->lang), $data, 200);
    }

    public function register(Request $request)
    {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'password' => 'required',
                'email' => 'required|unique:users',
                'user_name' => 'required|unique:users',
            ]);

            if ($validator->fails())
                return $this->errorResponse($validator->errors()->first(), 401);

        $user = User::where('email', $request->email)->first();
        if ($user)
            return $this->errorResponse(__('msg.already_registered',[],$this->lang), 401);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->fcm_token = $request->fcm_token;
        $user->business_name = $request->business_name;
        $user->user_name = $request->user_name;
        $user->birth_date = $request->birth_date;
        $user->social_token = $request->social_token;
        $user->user_type = $request->user_type;
        $user->status_id = 1;
        $user->password = Hash::make($request->password);
        $user->save();
        $token = auth()->login($user);

        $data = [
            'token' => $token,
            'user' => user_data()
        ];
        return $this->dataResponse(__('msg.register_successfully',[],$this->lang), $data, 200);
    }

    public function logout()
    {
        auth()->logout();

        return $this->successResponse(__('msg.logged_success',[],$this->lang), 200);
    }

    ############### end auth ######
}

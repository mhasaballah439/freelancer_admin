<?php

namespace App\Http\Controllers\Admin\Api;

use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\ContactUs;
use App\Models\Country;
use App\Models\HomeSetting;
use App\Models\Notifacations;
use App\Models\Onbording;
use App\Models\Portfolio;
use App\Models\Project;
use App\Models\ProjectOffer;
use App\Models\ProjectRate;
use App\Models\Service;
use App\Models\Settings;
use App\Models\Skill;
use App\Models\Slider;
use App\Models\Tag;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UsersCard;
use App\Traits\ApiTrait;
use CodeBugLab\NoonPayment\NoonPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SystemApiController extends Controller
{
    use ApiTrait;

    var $lang;
    var $user;

    public function __construct()
    {
        $this->lang = \request()->get('lang') ? \request()->get('lang') : 'ar';
        $this->user = auth()->user();
    }

    public function updateProfile(Request $request)
    {
        if ($request->email)
            $validator = Validator::make($request->all(), [
                'email' => 'unique:users,email,' . $this->user->id,
            ]);

        if ($request->phone)
            $validator = Validator::make($request->all(), [
                'phone' => 'unique:users,phone,' . $this->user->id,
            ]);
        if ($request->user_name)
            $validator = Validator::make($request->all(), [
                'user_name' => 'required|min:3|unique:users,user_name,' . $this->user->id,
            ]);


        if (isset($validator) && $validator->fails())
            return $this->errorResponse($validator->errors()->first(), 401);

        $user = User::find($this->user->id);
        if ($user) {
            $user->business_name = $request->business_name;
            if ($request->name)
                $user->name = $request->name;
            if ($request->user_name)
                $user->user_name = $request->user_name;
            if ($request->phone)
                $user->phone = $request->phone;
            if ($request->email)
                $user->email = $request->email;
            if ($request->id_num)
                $user->id_num = $request->id_num;
            if ($request->birth_date)
                $user->birth_date = date('Y-m-d', strtotime($request->birth_date));
            if ($request->user_type)
                $user->user_type = $request->user_type;
            if ($request->about_me)
                $user->about_me = $request->about_me;
            if ($request->skills)
                $user->skills = $request->skills;
            if ($request->fav_categories)
                $user->fav_categories = $request->fav_categories;
            if ($request->country_id)
                $user->country_id = $request->country_id;
            if ($request->user_skills)
                $user->user_skills = $request->user_skills;
            $user->save();
            if ($request->hasFile('image'))
                upload_file($request->image, 0, 'users', 'App\Models\User', $user->id, 'profile_image');

            if ($request->hasFile('files')) {
                foreach ($request->files as $file) {
                    foreach ($file as $file_item)
                        upload_file($file_item, 0, 'users', 'App\Models\User', $user->id, 'files');
                }
            }
            $tags = $user->tags ? Tag::whereIn('id',json_decode($user->tags))->get() : null;
            $user_skills = $user->user_skills;
            if (!is_array($user_skills))
                $user_skills = json_decode($user->user_skills);
            $data = [
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
                'birth_date' => date('d/m/Y', strtotime($user->birth_date)),
                'social_token' => $user->social_token ?? '',
                'skills' => $user->skills ? json_decode($user->skills) : [],
                'tags' => $tags ? $tags->map(function ($tag){
                return [
                  'id' => $tag->id,
                  'name' => $tag->name,
                    'image' => isset($tag->image) ? asset('public'.$tag->image->file_path) : '',
                ];
            }) : [],
                'fav_categories' => $user->fav_categories ? json_decode($user->fav_categories) : [],
                'user_skills' => $user->user_skills ? $user_skills : [],
                'image' => isset($user->image) ? asset('public' . $user->image->file_path) : '',
            ];
            return $this->dataResponse(__('msg.user_updated_successfully', [], $this->lang), $data, 200);
        }


    }

    public function findUserData(Request $request)
    {
        if ($request->id)
            $user = User::where('id', $request->id)->first();
        elseif ($request->user_name)
            $user = User::where('user_name', $request->user_name)->first();
        if (!$user)
            return $this->errorResponse(__('msg.user_not_found', [], $this->lang), 401);
        $tags = $user->tags ? Tag::whereIn('id', json_decode($user->tags))->get() : null;
        $skills = $user->skills ? Skill::whereIn('id', json_decode($user->skills))->get() : null;
        $user_skills = json_decode($user->user_skills);
        $userSkills = [];
        if ($user->user_skills) {
            foreach ($user_skills as $x) {
                $data = Skill::find($x->skills_id);
                if ($data) {
                    $userSkills[] = [
                        'id' => $data->id,
                        'name' => $data->name,
                        'skills_number' => $x->skills_number,
                    ];
                }
            }
        }
        $data = [
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
            'stars' => $user->stars,
            'complete_tasks' => round($user->complete_tasks,2),
            'on_time' => $user->on_time,
            'avg_work_days' => $user->avg_work_days,
            'user_type' => $user->user_type,
            'country_id' => $user->country_id,
            'country_name' => isset($user->country) ? $user->country->name : '',
            'id_num' => $user->id_num,
            'withdrawable_balance' => (float)$user->withdrawable_balance,
            'pending_balance' => (float)$user->pending_balance,
            'business_owner_palance' => (float)$user->business_owner_palance,
            'birth_date' => $user->birth_date ? date('d/m/Y', strtotime($user->birth_date)) : '',
            'social_token' => $user->social_token ?? '',
            'skills' => $skills ? $skills->map(function ($skill) {
                return [
                    'id' => $skill->id,
                    'name' => $skill->name,
                ];
            }) : [],
            'tags' => $tags ? $tags->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->name,
                    'image' => isset($tag->image) ? asset('public' . $tag->image->file_path) : '',
                ];
            }) : [],

            'fav_categories' => $user->fav_categories ? json_decode($user->fav_categories) : [],
            'user_skills' => $userSkills,
            'image' => isset($user->image) ? asset('public' . $user->image->file_path) : '',
            'portfolio' => isset($user->portfolio) && count($user->portfolio) > 0 ? $user->portfolio->map(function ($q) {
                $skills = $q->skills ? Skill::whereIn('id', json_decode($q->skills))->get() : null;
                return [
                    'id' => $q->id,
                    'title' => $q->title,
                    'url' => $q->url,
                    'desc' => $q->desc,
                    'active' => $q->active,
                    'work_date' => $q->work_date,
                    'image' => isset($q->image) ? asset('public' . $q->image->file_path) : '',
                    'skills' => $skills ? $skills->map(function ($skill) {
                        return [
                            'id' => $skill->id,
                            'name' => $skill->name,
                        ];
                    }) : [],
                ];
            }) : []
        ];
        return $this->dataResponse(__('msg.user_found_successfully', [], $this->lang), $data, 200);
    }

    public function getUserData()
    {
        $user = $this->user;
        $tags = $user->tags ? Tag::whereIn('id', json_decode($user->tags))->get() : null;
        $skills = $user->skills ? Skill::whereIn('id', json_decode($user->skills))->get() : null;
        $count_notify_not_read = Notifacations::where('user_id', $user->id)
            ->where('is_read', 0)->count();
        $count_msg_not_read = DB::table('ch_messages')->Where('from_id', $user->id)
            ->where('seen', 0)->groupBy('to_id')->count();

        $user_skills = $user->user_skills;
        if (!is_array($user_skills))
            $user_skills = json_decode($user->user_skills);

        $data = [
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
            'stars' => $user->stars,
            'user_type' => $user->user_type,
            'country_id' => $user->country_id,
            'country_name' => isset($user->country) ? $user->country->name : '',
            'id_num' => $user->id_num,
            'withdrawable_balance' => (float)$user->withdrawable_balance,
            'pending_balance' => (float)$user->pending_balance,
            'business_owner_palance' => (float)$user->business_owner_palance,
            'birth_date' => $user->birth_date ? date('d/m/Y', strtotime($user->birth_date)) : '',
            'social_token' => $user->social_token ?? '',
            'count_notify_not_read' => $count_notify_not_read,
            'count_msg_not_read' => $count_msg_not_read,
            'count_uploaded_files' => isset($user->files) ? count($user->files) : 0,
            'skills' => $skills ? $skills->map(function ($skill) {
                return [
                    'id' => $skill->id,
                    'name' => $skill->name,
                ];
            }) : [],
            'tags' => $tags ? $tags->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->name,
                    'image' => isset($tag->image) ? asset('public' . $tag->image->file_path) : '',
                ];
            }) : [],
            'fav_categories' => $user->fav_categories ? json_decode($user->fav_categories) : [],
            'user_skills' => $user->user_skills ? $user_skills : [],
            'image' => isset($user->image) ? asset('public' . $user->image->file_path) : '',
            'portfolio' => isset($user->portfolio) && count($user->portfolio) > 0 ? $user->portfolio->map(function ($q) {
                $skills = $q->skills ? Skill::whereIn('id', json_decode($q->skills))->get() : null;
                return [
                    'id' => $q->id,
                    'title' => $q->title,
                    'url' => $q->url,
                    'desc' => $q->desc,
                    'active' => $q->active,
                    'work_date' => $q->work_date,
                    'image' => isset($q->image) ? asset('public' . $q->image->file_path) : '',
                    'skills' => $skills ? $skills->map(function ($skill) {
                        return [
                            'id' => $skill->id,
                            'name' => $skill->name,
                        ];
                    }) : [],
                ];
            }) : []
        ];
        return $this->dataResponse(__('msg.user_found_successfully', [], $this->lang), $data, 200);
    }


    public function checkVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'active_code' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails())
            return $this->errorResponse($validator->errors()->first(), 401);

        $user = User::where('email', $request->email)->first();
        if (!$user)
            return $this->errorResponse(__('msg.user_not_found', [], $this->lang), 401);

        if ($request->active_code != $user->active_code)
            return $this->errorResponse(__('msg.code_error', [], $this->lang), 401);

        $user->status_id = 1;
        $user->save();
        $token = auth()->login($user);
        $data = [
            'user' => user_data(),
            'user_data' => user_data(),
            'token' => $token
        ];
        return $this->dataResponse(__('msg.code_checd_success', [], $this->lang), $data, 200);
    }

    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails())
            return $this->errorResponse($validator->errors()->first(), 401);

        $user = User::where('email', $request->email)->first();
        if (!$user)
            return $this->errorResponse(__('msg.user_not_found', [], $this->lang), 401);

        $user->active_code = rand(1111, 9999);
        $user->save();
//        Mail::send(['html' => 'emails.verify_account'], ['name' => $user->name, 'code' => $user->active_code], function ($message) use ($user) {
//            $message->from('no-replay@boardfreelancers.com', 'boardfreelancers.com');
//            $message->subject('Active board account');
//            $message->to($user->email);
//        });
        $msg = __('msg.sms_send_successfully', [], $this->lang);
        return $this->successResponse('code is ' . $user->active_code, 200);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails())
            return $this->errorResponse($validator->errors()->first(), 401);


        if ($request->password != $request->password_confirmation)
            return $this->errorResponse(__('msg.password_not_equal_confirmation', [], $this->lang), 401);
        $user = $this->user;
        $user->password = bcrypt($request->password);
        $user->save();


        return $this->successResponse(__('msg.password_change_success', [], $this->lang), 200);
    }

    public function resendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails())
            return $this->errorResponse($validator->errors()->first(), 401);

        $user = User::where('email', $request->email)->first();
        if (!$user)
            return $this->errorResponse(__('msg.user_not_found', [], $this->lang), 401);

        $user->active_code = rand(1111, 9999);
        $user->save();
//        Mail::send(['html' => 'emails.verify_account'], ['name' => $user->name, 'code' => $user->active_code], function ($message) use ($user) {
//            $message->from('no-replay@board.net', 'board.net');
//            $message->subject('Active board account');
//            $message->to($user->email);
//        });
        return $this->successResponse(__('msg.sms_send_successfully', [], $this->lang), 200);
    }


    public function inBordingData()
    {
        $in_bording = Onbording::Active()->get();

        $data = $in_bording->map(function ($bording) {
            return [
                'image' => $bording->image ? asset('/public' . $bording->image) : '',
                'title' => $bording->title ? $bording->title : '',
                'desc' => $bording->desc ? $bording->desc : '',
            ];
        });

        return $this->dataResponse(__('msg.data_found_successfully', [], $this->lang), $data, 200);
    }

    public function settings()
    {
        $setting = Settings::first();
        $langArArr = [];
        $langEnArr = [];
        if ($setting->string_text) {
            foreach (json_decode($setting->string_text) as $item) {
                $langArArr[] = [
                    'code' => $item->code,
                    'name' => $item->name_ar,
                ];
                $langEnArr[] = [
                    'code' => $item->code,
                    'name' => $item->name_en,
                ];
            }
        }

        $home_setting = HomeSetting::first();
        $partners = isset($home_setting->files) && count($home_setting->files) > 0 ? $home_setting->files()->where('type', '=', 'partners')->get() : [];
        $app_files = isset($home_setting->files) && count($home_setting->files) > 0 ? $home_setting->files()->where('type', '=', 'app_files')->get() : [];

        $data = [
            'phone' => $setting->phone ? $setting->phone : '',
            'email' => $setting->email ? $setting->email : '',
            'seo_title' => $setting->seo_title ? $setting->seo_title : '',
            'seo_desc' => $setting->seo_desc ? $setting->seo_desc : '',
            'seo_keyword' => $setting->seo_keyword ? $setting->seo_keyword : '',
            'whatsapp' => $setting->whatsapp ? $setting->whatsapp : '',
            'facebook' => $setting->facebook ? $setting->facebook : '',
            'instagram' => $setting->instagram ? $setting->instagram : '',
            'twitter' => $setting->twitter ? $setting->twitter : '',
            'tax' => $setting->tax,
            'profit_rate' => $setting->profit_rate,
            'min_project_price' => $setting->min_project_price,
            'logo' => $setting->logo ? asset('public' . $setting->logo) : '',
            'fav_icon' => $setting->fav_icon ? asset('public' . $setting->fav_icon) : '',
            'about_us' => $setting->about_us,
            'terms_conditions' => $setting->terms_conditions,
            'policy' => $setting->policy,
            'app_title' => $home_setting->app_title,
            'app_android' => $home_setting->app_android,
            'app_ios' => $home_setting->app_ios,
            'app_desc' => $home_setting->app_desc,
            'footer_text' => $home_setting->footer_text,
            'partners' => count($partners) > 0 ? $partners->map(function ($file) {
                return [
                    'image' => asset('public' . $file->file_path)
                ];
            }) : [],
            'app_files' => count($app_files) > 0 ? $app_files->map(function ($file) {
                return [
                    'image' => asset('public' . $file->file_path)
                ];
            }) : [],
            'string_text' => [
                'ar' => $langArArr,
                'en' => $langEnArr,
            ],
        ];

        return $this->dataResponse(__('msg.data_found_successfully', [], $this->lang), $data, 200);
    }

    public function changeUserPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required',
            'new_password_conformation' => 'required',
        ]);
        if ($validator->fails())
            return response()->json([
                'status' => 401,
                'msg' => $validator->errors()->first()
            ]);

        if (!(Hash::check($request->current_password, $this->user->password)))
            return response()->json([
                'status' => 401,
                'msg' => __('msg.pass_not_match', [], $this->lang)
            ]);

        if ($request->current_password == $request->new_password)
            return response()->json([
                'status' => 401,
                'msg' => __('msg.pass_equal_cu_pas', [], $this->lang)
            ]);
        if ($request->new_password != $request->new_password_conformation)
            return response()->json([
                'status' => 401,
                'msg' => __('msg.pass_equal_cu_pas_confirm', [], $this->lang)
            ]);


        $user = $this->user;
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return response()->json([
            'status' => 200,
            'msg' => __('msg.pass_changed_success', [], $this->lang)
        ]);
    }

    ######################### projects #######################3
    public function categories()
    {
        $categories = Categories::Active()->get();
        $data = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->api_name($this->lang),
                'slug' => $category->slug ?? '',
                'image' => $category->image ? asset('public' . $category->image) : '',
            ];
        });
        return $this->dataResponse(__('msg.data_get_successfully', [], $this->lang), $data, 200);
    }

    public function projects(Request $request)
    {
        $projects = Project::where('status_id', 1);
        if ($request->categories)
            $projects = $projects->whereIn('category_id', $request->categories);
        if ($request->search)
            $projects = $projects->where('title', 'LIKE', '%' . $request->search . '%')
                ->orWhere('desc', 'LIKE', '%' . $request->search . '%');
        if ($request->from_price && $request->to_price)
            $projects = $projects->where('from_price', '>=', $request->from_price)
                ->where('to_price', '<=', $request->to_price);
        if ($request->sort_by) {
            if ($request->sort_by == 1)
                $projects = $projects->orderBy('id', 'DESC');
            else
                $projects = $projects->orderBy('id', 'asc');
        }
        if ($request->period_work) {
            if ($request->period_work == 1)
                $projects = $projects->where('work_period_days', '<', 7);
            elseif ($request->period_work == 2)
                $projects = $projects->whereBetween('work_period_days', [7, 14]);
            elseif ($request->period_work == 3)
                $projects = $projects->whereBetween('work_period_days', [14, 30]);
            elseif ($request->period_work == 4)
                $projects = $projects->where('work_period_days', '>', 30);
        }

        $projects = $projects->orderBy('id', 'DESC')->paginate(20);

        $data = [
            'count' => $projects->count(),
            'currentPage' => $projects->currentPage(),
            'firstItem' => $projects->firstItem(),
            'getOptions' => $projects->getOptions(),
            'hasPages' => $projects->hasPages(),
            'lastItem' => $projects->lastItem(),
            'lastPage' => $projects->lastPage(),
            'nextPageUrl' => $projects->nextPageUrl(),
            'perPage' => $projects->perPage(),
            'total' => $projects->total(),
            'getPageName' => $projects->getPageName(),
            'projects' => $projects->map(function ($project) {
                $formattedCreatedAt = $project->created_at->diffForHumans();
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'desc' => $project->desc,
                    'slug' => $project->slug,
                    'status_name' => $project->api_status_name($this->lang),
                    'status_id' => $project->status_id,
                    'work_period_days' => $project->work_period_days,
                    'count_offers' => count($project->offers) > 0 ? count($project->offers) : 0,
                    'offers' => count($project->offers) > 0 ? $project->offers : 0,
                    'user_is_offer' => $this->user ? $project->user_offer($this->user->id) : 0,
                    'category' => isset($project->category) ? $project->category->name : '',
                    'business_owner_name' => isset($project->business_owner) ? $project->business_owner->name : '',
                    'business_owner_stars' => isset($project->business_owner) ? $project->business_owner->stars : '',
                    'business_owner_image' => isset($project->business_owner->image) ? asset('public' . $project->business_owner->image->file_path) : '',
                    'created_at_date' => date('d/m/Y', strtotime($project->created_at)),
                    'created_at_time' => date('H:i A', strtotime($project->created_at)),
                    'from_price' => (float)$project->from_price,
                    'to_price' => (float)$project->to_price,
                    'work_price' => $project->work_price,
                    'created_at_formated' => $formattedCreatedAt,
                ];
            })
        ];
        return $this->dataResponse(__('msg.projects_get_successfully', [], $this->lang), $data, 200);
    }

    public function projectDetails(Request $request)
    {
        $project = Project::find($request->project_id);

        if (!$project)
            return $this->errorResponse(__('msg.project_not_found'), 401);
        $offers_freelancers = [];
        if (isset($project->offers) && count($project->offers) > 0)
            $offers_freelancers = $project->offers()->whereHas('freelancer', function ($q) {
                $q->Has('image');
            })->get();

        $formattedCreatedAt = $project->created_at->diffForHumans();

        $data = [
            'id' => $project->id,
            'slug' => $project->slug ?? '',
            'title' => $project->title,
            'desc' => $project->desc,
            'status_name' => $project->api_status_name($this->lang),
            'status_id' => $project->status_id,
            'work_period_days' => $project->work_period_days,
            'from_price' => (float)$project->from_price,
            'to_price' => (float)$project->to_price,
            'price_bid' => $project->price_bid,
            'created_at_formated' => $formattedCreatedAt,
            'user_is_offer' => $this->user ? $project->user_offer($this->user->id) : 0,
            'count_offers' => count($project->offers) > 0 ? count($project->offers) : 0,
            'category' => isset($project->category) ? $project->category->name : '',
            'business_owner_name' => isset($project->business_owner) ? $project->business_owner->name : '',
            'business_owner_user_name' => isset($project->business_owner) ? $project->business_owner->user_name : '',
            'business_owner_stars' => isset($project->business_owner) ? $project->business_owner->stars : '',
            'business_owner_image' => isset($project->business_owner->image) ? asset('public' . $project->business_owner->image->file_path) : '',
            'freelancer_name' => isset($project->freelancer) ? $project->freelancer->name : '',
            'freelancer_user_name' => isset($project->freelancer) ? $project->freelancer->user_name : '',
            'freelancer_stars' => isset($project->freelancer) ? $project->freelancer->stars : '',
            'freelancer_count_rates' => isset($project->freelancer->freelancer_rate) ? count($project->freelancer->freelancer_rate) : 0,
            'freelancer_image' => isset($project->freelancer->image) ? asset('public' . $project->freelancer->image->file_path) : '',
            'created_at_date' => date('d/m/Y', strtotime($project->created_at)),
            'st_date' => date('d/m/Y', strtotime($project->st_date)),
            'end_date' => date('d/m/Y', strtotime($project->end_date)),
            'freelancer_work_days' => $project->freelancer_work_days,
            'freelancer_id' => $project->freelancer_id,
            'business_owner_id' => $project->business_owner_id,
            'work_price' => $project->work_price,
            'created_at_time' => date('H:i A', strtotime($project->created_at)),
            'rate' => isset($project->rate) ? $project->rate : null,
            'skills_list' => $project->skills_list && count($project->skills_list) > 0 ? $project->skills_list->map(function ($skill) {
                return [
                    'id' => $skill->id,
                    'name' => $skill->name,
                ];
            }) : [],
            'files' => $project->files && count($project->files) > 0 ? $project->files->map(function ($file) {
                return [
                    'id' => $file->id,
                    'file' => asset('public' . $file->file_path),
                ];
            }) : [],
            'offers_freelancers_images' => count($offers_freelancers) > 0 ? $offers_freelancers->map(function ($offer) {
                return [
                    'freelancer_image' => asset('public' . $offer->freelancer->image->file_path),
                ];
            }) : [],
            'offers' => isset($project->offers) && count($project->offers) > 0 ? $project->offers->map(function ($offer) {
                $formattedCreatedAt = $offer->created_at->diffForHumans();
                return [
                    'id' => $offer->id,
                    'desc' => $offer->desc,
                    'freelancer_id' => $offer->freelancer_id,
                    'work_period_days' => $offer->work_period_days,
                    'price' => (float)$offer->price,
                    'freelancer_name' => isset($offer->freelancer) ? $offer->freelancer->name : '',
                    'freelancer_user_name' => isset($offer->freelancer) ? $offer->freelancer->user_name : '',
                    'freelancer_stars' => isset($offer->freelancer) ? $offer->freelancer->stars : '',
                    'freelancer_count_reviews' => isset($offer->freelancer->freelancer_rate) && count($offer->freelancer->freelancer_rate) > 0 ? count($offer->freelancer->freelancer_rate) : 0,
                    'freelancer_image' => isset($offer->freelancer->image) ? asset('public' . $offer->freelancer->image->file_path) : '',
                    'created_at' => date('d/m/Y H:i A', strtotime($offer->created_at)),
                    'created_at_formated' => $formattedCreatedAt,
                    'files' => $offer->files && count($offer->files) > 0 ? $offer->files->map(function ($ofile) {
                        return [
                            'id' => $ofile->id,
                            'file' => asset('public' . $ofile->file_path),
                        ];
                    }) : [],
                ];
            }) : [],
        ];


        return $this->dataResponse(__('msg.project_get_successfully', [], $this->lang), $data, 200);
    }

    ##################### website home screen ###########################

    public function slider()
    {
        $sliders = Slider::Active()->orderBy('id', 'DESC')->get();

        $data = $sliders->map(function ($slider) {
            return [
                'id' => $slider->id,
                'title' => $slider->api_title($this->lang),
                'desc' => $slider->api_desc($this->lang),
                'btn2_text' => $slider->api_btn2_text($this->lang) ?? '',
                'btn1_text' => $slider->api_btn1_text($this->lang) ?? '',
                'btn1_url' => $slider->btn1_url ?? '',
                'btn2_url' => $slider->btn2_url ?? '',
                'image' => $slider->image ? asset('public' . $slider->image) : '',
            ];
        });

        return $this->dataResponse(__('msg.sliders_get_successfully', [], $this->lang), $data, 200);
    }

    public function services()
    {
        $services = Service::Active()->orderBy('id', 'asc')->get();

        $data = $services->map(function ($service) {
            return [
                'id' => $service->id,
                'title' => $service->api_title($this->lang),
                'desc' => $service->api_desc($this->lang),
                'image' => $service->image ? asset('public' . $service->image) : '',
            ];
        });

        return $this->dataResponse(__('msg.services_get_successfully', [], $this->lang), $data, 200);
    }

    public function homeSettings()
    {
        $home_setting = HomeSetting::first();
        $partners = isset($home_setting->files) && count($home_setting->files) > 0 ? $home_setting->files()->where('type', '=', 'partners')->get() : [];
        $app_files = isset($home_setting->files) && count($home_setting->files) > 0 ? $home_setting->files()->where('type', '=', 'app_files')->get() : [];
        $data = [
            'app_title' => $home_setting->api_app_title($this->lang),
            'app_android' => $home_setting->app_android,
            'app_ios' => $home_setting->app_ios,
            'app_desc' => $home_setting->api_app_desc($this->lang),
            'footer_text' => $home_setting->api_footer_text($this->lang),
            'partners' => count($partners) > 0 ? $partners->map(function ($file) {
                return [
                    'image' => asset('public' . $file->file_path)
                ];
            }) : [],
            'app_files' => count($app_files) > 0 ? $app_files->map(function ($file) {
                return [
                    'image' => asset('public' . $file->file_path)
                ];
            }) : [],
        ];

        return $this->dataResponse(__('msg.settings_get_successfully', [], $this->lang), $data, 200);
    }

    #####################auth projects###########################################
    public function freelancerProjects(Request $request)
    {
        $status_id = $request->get('status_id');
        $projects = Project::where('freelancer_id', $this->user->id);
        if ($status_id)
            $projects = $projects->where('status_id', $status_id);

        $projects = $projects->orderBy('id', 'DESC')->paginate(20);

        $data = [
            'count' => $projects->count(),
            'currentPage' => $projects->currentPage(),
            'firstItem' => $projects->firstItem(),
            'getOptions' => $projects->getOptions(),
            'hasPages' => $projects->hasPages(),
            'lastItem' => $projects->lastItem(),
            'lastPage' => $projects->lastPage(),
            'nextPageUrl' => $projects->nextPageUrl(),
            'perPage' => $projects->perPage(),
            'total' => $projects->total(),
            'getPageName' => $projects->getPageName(),
            'projects' => $projects->map(function ($project) {
                $formattedCreatedAt = $project->created_at->diffForHumans();
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'desc' => $project->desc,
                    'work_period_days' => $project->work_period_days,
                    'slug' => $project->slug ?? '',
                    'status_name' => $project->api_status_name($this->lang),
                    'status_id' => $project->status_id,
                    'user_is_offer' => $this->user ? $project->user_offer($this->user->id) : 0,
                    'is_business_owner_bay' => $project->is_business_owner_bay($project->business_owner_id),
                    'count_offers' => count($project->offers) > 0 ? count($project->offers) : 0,
                    'category' => isset($project->category) ? $project->category->name : '',
                    'business_owner_name' => isset($project->business_owner) ? $project->business_owner->name : '',
                    'business_owner_stars' => isset($project->business_owner) ? $project->business_owner->stars : '',
                    'business_owner_image' => isset($project->business_owner->image) ? asset('public' . $project->business_owner->image->file_path) : '',
                    'created_at_date' => date('d/m/Y', strtotime($project->created_at)),
                    'created_at_time' => date('H:i A', strtotime($project->created_at)),
                    'from_price' => (float)$project->from_price,
                    'to_price' => (float)$project->to_price,
                    'work_price' => $project->work_price,
                    'created_at_formated' => $formattedCreatedAt,
                ];
            })
        ];

        return $this->dataResponse(__('msg.projects_get_successfully', [], $this->lang), $data, 200);
    }

    public function businessOwnerProjects(Request $request)
    {
        $status_id = $request->get('status_id');
        $projects = Project::where('business_owner_id', $this->user->id);
        if ($status_id)
            $projects = $projects->where('status_id', $status_id);
        $projects = $projects->orderBy('id', 'DESC')->paginate(20);

        $data = [
            'count' => $projects->count(),
            'currentPage' => $projects->currentPage(),
            'firstItem' => $projects->firstItem(),
            'getOptions' => $projects->getOptions(),
            'hasPages' => $projects->hasPages(),
            'lastItem' => $projects->lastItem(),
            'lastPage' => $projects->lastPage(),
            'nextPageUrl' => $projects->nextPageUrl(),
            'perPage' => $projects->perPage(),
            'total' => $projects->total(),
            'getPageName' => $projects->getPageName(),
            'projects' => $projects->map(function ($project) {
                $formattedCreatedAt = $project->created_at->diffForHumans();
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'desc' => $project->desc,
                    'slug' => $project->slug,
                    'status_name' => $project->api_status_name($this->lang),
                    'status_id' => $project->status_id,
                    'is_business_owner_bay' => $project->is_business_owner_bay($project->business_owner_id),
                    'work_period_days' => $project->work_period_days,
                    'user_is_offer' => $this->user ? $project->user_offer($this->user->id) : 0,
                    'count_offers' => count($project->offers) > 0 ? count($project->offers) : 0,
                    'category' => isset($project->category) ? $project->category->name : '',
                    'business_owner_name' => isset($project->business_owner) ? $project->business_owner->name : '',
                    'business_owner_stars' => isset($project->business_owner) ? $project->business_owner->stars : '',
                    'business_owner_image' => isset($project->business_owner->image) ? asset('public' . $project->business_owner->image->file_path) : '',
                    'created_at_date' => date('d/m/Y', strtotime($project->created_at)),
                    'created_at_time' => date('H:i A', strtotime($project->created_at)),
                    'from_price' => (float)$project->from_price,
                    'to_price' => (float)$project->to_price,
                    'work_price' => $project->work_price,
                    'created_at_formated' => $formattedCreatedAt,
                ];
            })
        ];


        return $this->dataResponse(__('msg.projects_get_successfully', [], $this->lang), $data, 200);
    }

    public function freelancerAddOffer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required',
        ]);

        if ($validator->fails())
            return $this->errorResponse($validator->errors()->first(), 401);
        if ($this->user->user_type != 1)
            return $this->errorResponse(__('msg.account_must_to_be_freelancer', [], $this->lang), 401);

        $project = Project::find($request->project_id);
        if (!$project)
            return $this->errorResponse(__('msg.project_not_found', [], $this->lang), 401);
        $offer = ProjectOffer::where('project_id', $project->id)->where('freelancer_id', $this->user->id)->first();
        if ($offer)
            return $this->errorResponse(__('msg.freelancer_already_submit_offer', [], $this->lang), 401);

        if ($project->status_id > 1)
            return $this->errorResponse(__('msg.you_cannot_apply_for_the_project', [], $this->lang), 401);
        $offer = new ProjectOffer();
        $offer->freelancer_id = $this->user->id;
        $offer->project_id = $project->id;
        $offer->price = $request->price;
        $offer->work_period_days = $request->work_period_days;
        $offer->desc = $request->desc;
        $offer->save();

        if ($request->hasFile('files')) {
            foreach ($request->files as $files) {
                foreach ($files as $file)
                    upload_file($file, 0, 'project_offers', 'App\Models\ProjectOffer', $offer->id, null);
            }
        }
        $notification = new Notifacations();
        $notification->user_id = $project->business_owner_id;
        $notification->type_id = 1;
        $notification->project_id = $project->id;
        $notification->notify = ' تم اضافة عرض جديد على المشروع  ' . $project->title;
        $notification->save();
        $eventName = 'user_notification';

        send_pusher_notification($notification->notify, $eventName, $notification->user_id, $notification->type_id, $notification->project_id, 0);

        $user = User::find($notification->user_id);
        if ($user)
            sendToFcm($user->fcm_token, $notification->notify, 'اشعار جديد من بورد');
        return $this->successResponse(__('msg.offer_created_success', [], $this->lang), 200);
    }

    public function freelancerUpdateOffer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'offer_id' => 'required',
        ]);

        if ($validator->fails())
            return $this->errorResponse($validator->errors()->first(), 401);

        $offer = ProjectOffer::where('id', $request->offer_id)->where('freelancer_id', $this->user->id)->first();
        if (!$offer)
            return $this->errorResponse(__('msg.offer_not_found', [], $this->lang), 401);

        if ($offer->project->status_id != 1)
            return $this->errorResponse(__('msg.You_cannot_modify_the_offer', [], $this->lang), 401);

        if ($request->price)
            $offer->price = $request->price;
        if ($request->work_period_days)
            $offer->work_period_days = $request->work_period_days;
        if ($request->desc)
            $offer->desc = $request->desc;
        $offer->save();

        if ($request->hasFile('files')) {
            foreach ($request->files as $files) {
                foreach ($files as $file)
                    upload_file($file, 0, 'project_offers', 'App\Models\ProjectOffer', $offer->id, null);
            }
        }

        $freelancer_name = $offer->freelancer->name ?? '';

        $notification = new Notifacations();
        $notification->user_id = $offer->project->business_owner_id ?? 0;
        $notification->type_id = 1;
        $notification->project_id = $offer->project->id ?? 0;
        $notification->notify = $freelancer_name . ' تم تعديل عرض المستخدم ' . $offer->project->title . ' على المشروع ';
        $notification->save();

        $eventName = 'user_notification';
        send_pusher_notification($notification->notify, $eventName, $notification->user_id, $notification->type_id, $notification->project_id, 0);

        $user = User::find($notification->user_id);
        if ($user)
            sendToFcm($user->fcm_token, $notification->notify, 'اشعار جديد من بورد');
        return $this->successResponse(__('msg.offer_created_success', [], $this->lang), 200);
    }

    public function acceptOffer(Request $request)
    {
        if ($this->user->user_type != 2)
            return $this->errorResponse(__('msg.account_must_to_be_business_owner', [], $this->lang), 401);

        $offer = ProjectOffer::find($request->id);
        if (!$offer)
            return $this->errorResponse(__('msg.offer_not_found'), 401);

        $price = $request->price ? $request->price : $offer->price;
        if ($this->user->business_owner_palance < $price)
            return $this->errorResponse(__('msg.You_do_not_have_enough_balance_to_accept_the_offerYou_must_top_up_your_wallet', [], $this->lang), 401);

        $project = Project::where('id', $offer->project_id)->where('freelancer_id', '>', 0)->first();
        if ($project)
            return $this->errorResponse(__('msg.project_already_submited', [], $this->lang), 401);
        $project = Project::find($offer->project_id);
        if (!$project)
            return $this->errorResponse(__('msg.project_not_found', [], $this->lang), 401);

        $cu_date = date('Y-m-d');
        $project->freelancer_id = $offer->freelancer_id ?? 0;
        $project->status_id = 2;
        $project->st_date = $cu_date;
        $project->end_date = date('Y-m-d', strtotime($cu_date . '+' . $offer->work_period_days . ' days'));
        $project->freelancer_work_days = $offer->work_period_days;
        $project->work_price = $price;
        $project->save();

        $business_owner_name = isset($project->business_owner) ? $project->business_owner->business_name : '';
        $notify = new Notifacations();
        $notify->user_id = $project->freelancer_id;
        $notify->type_id = 1;
        $notify->project_id = $project->id;
        $notify->notify = 'تم الموافقة على عرضك من قبل ' . $business_owner_name;
        $notify->save();

        $eventName = 'user_notification';
        send_pusher_notification($notify->notify, $eventName, $notify->user_id, $notify->type_id, $notify->project_id, 0);
        $user = User::find($notify->user_id);
        if ($user)
            sendToFcm($user->fcm_token, $notify->notify, 'اشعار جديد من بورد');

        $notify = new Notifacations();
        $notify->user_id = $this->user->id;
        $notify->type_id = 1;
        $notify->project_id = $project->id;
        $notify->notify = 'تم قمت بالموافقة على الوظيفة ' . $project->id . ' الموظف ' . $project->freelancer->name;
        $notify->save();

        $eventName = 'user_notification';
        send_pusher_notification($notify->notify, $eventName, $notify->user_id, $notify->type_id, $notify->project_id, 0);

        $user = User::find($notify->user_id);
        if ($user)
            sendToFcm($user->fcm_token, $notify->notify, 'اشعار جديد من بورد');
        return $this->successResponse(__('msg.offer_accepted_success', [], $this->lang), 200);
    }

    public function deleteOffer(Request $request)
    {
        if ($this->user->user_type != 1)
            return $this->errorResponse(__('msg.account_must_to_be_freelancer', [], $this->lang), 401);

        $offer = ProjectOffer::where('id', $request->id)->where('freelancer_id', $this->user->id)->first();
        if (!$offer)
            return $this->errorResponse(__('msg.offer_not_found'), 401);

        $project = Project::where('id', $offer->project_id)->where('freelancer_id', $this->user->id)->first();
        if ($project)
            return $this->errorResponse(__('msg.canot_remove_project_submited', [], $this->lang), 401);
        $title = isset($offer->project) && $offer->project->title ? $offer->project->title : '';
        $project_id = isset($offer->project) && $offer->project->id ? $offer->project->id : 0;
        $project_business_owner_id = isset($offer->project) && $offer->project->business_owner_id ? $offer->project->business_owner_id : 0;
        $msg = $title.' على المشروع '.$this->user->name . 'تم حذف العرض من قبل  ';

        $notify = new Notifacations();
        $notify->user_id = $project_business_owner_id ?? 0;
        $notify->type_id = 1;
        $notify->project_id = $project_id ?? 0;
        $notify->notify = $msg;
        $notify->save();

        $eventName = 'user_notification';
        send_pusher_notification($msg, $eventName, $notify->user_id, 1, $project_id, 0);

        $user2 = User::find($notify->user_id);
        if ($user2)
            sendToFcm($user2->fcm_token, $msg, 'اشعار جديد من بورد');

        $offer->delete();



        return $this->successResponse(__('msg.offer_deleted_success', [], $this->lang), 200);
    }

    public function freelancerOfferList()
    {
        if ($this->user->user_type != 1)
            return $this->errorResponse(__('msg.account_must_to_be_freelancer', [], $this->lang), 401);
        $offers = ProjectOffer::where('freelancer_id', $this->user->id)->orderBy('id', 'DESC')->paginate(10);

        $data = [
            'count' => $offers->count(),
            'currentPage' => $offers->currentPage(),
            'firstItem' => $offers->firstItem(),
            'getOptions' => $offers->getOptions(),
            'hasPages' => $offers->hasPages(),
            'lastItem' => $offers->lastItem(),
            'lastPage' => $offers->lastPage(),
            'nextPageUrl' => $offers->nextPageUrl(),
            'perPage' => $offers->perPage(),
            'total' => $offers->total(),
            'getPageName' => $offers->getPageName(),
            'data' => $offers->map(function ($offer) {
                return [
                    'id' => $offer->id,
                    'desc' => $offer->desc,
                    'freelancer_id' => $offer->freelancer_id,
                    'work_period_days' => $offer->work_period_days,
                    'price' => (float)$offer->price,
                    'project_title' => isset($offer->project) ? $offer->project->title : '',
                    'project_id' => isset($offer->project) ? $offer->project->id : 0,
                    'project_slug' => isset($offer->project) ? $offer->project->slug : '',
                    'project_desc' => isset($offer->project) ? $offer->project->desc : '',
                    'created_at' => date('d/m/Y H:i A', strtotime($offer->created_at)),
                    'files' => $offer->files && count($offer->files) > 0 ? $offer->files->map(function ($ofile) {
                        return [
                            'id' => $ofile->id,
                            'file' => asset('public' . $ofile->file_path),
                        ];
                    }) : [],
                ];
            })
        ];
        return $this->dataResponse(__('msg.data_get_successfully', [], $this->lang), $data, 200);
    }

    public function updateProjectStatus(Request $request)
    {
        if ($this->user->user_type != 2)
            return $this->errorResponse(__('msg.account_must_to_be_business_owner', [], $this->lang), 401);

        $project = Project::find($request->id);
        if (!$project)
            return $this->errorResponse('لم يتم العثور على المشروع', 401);
        $project->status_id = $request->status_id;
        $project->save();
        if ($project->status_id == 3){
            $owner = User::find($this->user->id);
            $freelancer = User::find($project->freelancer_id);

            $owner->business_owner_palance = ($owner->business_owner_palance - $project->work_price);
            $owner->save();

            $freelancer->pending_balance = ($freelancer->pending_balance + $project->work_price);
            $freelancer->save();


            $transaction = new Transaction();
            $transaction->project_id = $project->id;
            $transaction->freelancer_id = $freelancer->id;
            $transaction->business_owner_id = $owner->id;
            $transaction->type_id = 3;
            $transaction->price = $project->work_price;
            $transaction->code = $this->genrateTransactionNumber();
            $transaction->status_id = 2;
            $transaction->save();

        }
        $msg = $project->status_name . ' الى  ' . $project->title . ' تم التعديل على حالة المشروع ';

        $notify = new Notifacations();
        $notify->user_id = $project->freelancer_id;
        $notify->type_id = 1;
        $notify->project_id = $project->id;
        $notify->notify = $msg;
        $notify->save();

        $notify = new Notifacations();
        $notify->user_id = $project->business_owner_id;
        $notify->type_id = 1;
        $notify->project_id = $project->id;
        $notify->notify = $msg;
        $notify->save();

        $eventName = 'user_notification';
        send_pusher_notification($msg, $eventName, $project->freelancer_id, 1, $project->id, 0);
        send_pusher_notification($msg, $eventName, $project->business_owner_id, 1, $project->id, 0);

        $user1 = User::find($project->freelancer_id);
        $user2 = User::find($project->business_owner_id);
        if ($user1)
            sendToFcm($user1->fcm_token, $msg, 'اشعار جديد من بورد');
        if ($user2)
            sendToFcm($user2->fcm_token, $msg, 'اشعار جديد من بورد');
        return $this->successResponse(__('msg.status_updated_success', [], $this->lang), 200);
    }

    #################### cards #######################333
    public function usersCards()
    {
        $user_cards = UsersCard::where('user_id', $this->user->id)->orderBy('id', 'DESC')->get();
        $data = $user_cards->map(function ($card) {
            return [
                'id' => $card->id,
                'ex_month' => $card->ex_month,
                'ex_year' => $card->ex_year,
                'holder_name' => $card->holder_name,
                'last_4number' => $card->last_4number,
                'is_default' => $card->is_default,
                'brand' => $card->brand,
                'created_at' => $card->created_at,
            ];
        });
        return $this->dataResponse('Card get success', $data, 200);
    }


    public function addUserCard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_number' => 'required',
            'ex_month' => 'required',
            'ex_year' => 'required',
            'cvv' => 'required',
        ]);

        if ($validator->fails())
            return $this->errorResponse($validator->errors()->first(), 401);

        $card_num = $request->card_number;
        $user_card = UsersCard::where('user_id', $this->user->id)->where('last_4number', substr($card_num, -4))->first();
        $brand = substr($card_num, 0, 1) == '5' ? 'Master card' : 'Visa';

        if ($request->is_default == 1)
            UsersCard::where('user_id', $this->user->id)->update(['is_default' => 0]);
        if (!$user_card)
            $user_card = new UsersCard();
        $user_card->card_number = encrypt($request->card_number);
        $user_card->ex_month = $request->ex_month;
        $user_card->ex_year = $request->ex_year;
        $user_card->cvv = $request->cvv;
        $user_card->brand = $brand;
        $user_card->holder_name = $request->card_holder_name ? $request->card_holder_name : $this->user->name;
        $user_card->last_4number = substr($card_num, -4);
        $user_card->is_default = $request->is_default == 1 ? 1 : 0;
        $user_card->user_id = $this->user->id;
        $user_card->save();

        return $this->successResponse('Card saved success', 200);
    }

    public function deleteCard(Request $request)
    {
        $user_card = UsersCard::where('user_id', $this->user->id)->where('id', $request->id)->first();

        if (!$user_card)
            return $this->errorResponse('Card not found', 401);

        $user_card->delete();

        return $this->successResponse('Card deleted success', 200);
    }

    ################## transactions ###################3

    public function businessOwnerTransactions()
    {
        $transactions = Transaction::where('business_owner_id', $this->user->id)->get();
        $data = $transactions->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'project_id' => $transaction->project_id,
                'project_title' => $transaction->project->title ?? '',
                'type' => $transaction->type_name,
                'status_name' => $transaction->api_status_name($this->lang),
                'price' => $transaction->price,
                'type_id' => $transaction->type_id,
                'is_payment' => $transaction->is_payment,
                'payment' => $transaction->payment,
                'created_at' => date('d/m/Y H:i A', strtotime($transaction->created_at)),
            ];
        });

        return $this->dataResponse(__('msg.transactions_get_success', [], $this->lang), $data, 200);
    }

    public function freelancerTransactions()
    {
        $transactions = Transaction::where('freelancer_id', $this->user->id)->get();
        $data = $transactions->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'project_id' => $transaction->project_id,
                'business_owner_image' => isset($transaction->business_owner->image) ? asset('public' . $transaction->business_owner->image->file_path) : '',
                'business_owner_name' => $transaction->business_owner->name ?? '',
                'project_title' => $transaction->project->title ?? '',
                'type' => $transaction->type_name,
                'type_id' => $transaction->type_id,
                'price' => (float)$transaction->price,
                'status_name' => $transaction->api_status_name($this->lang),
                'is_payment' => $transaction->is_payment,
                'payment' => $transaction->payment,
                'created_at' => date('d/m/Y H:i A', strtotime($transaction->created_at)),
            ];
        });

        return $this->dataResponse(__('msg.transactions_get_success', [], $this->lang), $data, 200);
    }

    ################# notifacations ###############

    public function userNotifacations()
    {
        $notifications = Notifacations::where('user_id', $this->user->id)->orderBy('id', 'DESC')->get();

        $data = $notifications->map(function ($notify) {
            $formattedCreatedAt = $notify->created_at->diffForHumans();
            return [
                'id' => $notify->id,
                'notify' => $notify->notify,
                'is_read' => $notify->is_read,
                'type_id' => $notify->type_id,
                'type_name' => $notify->type_name,
                'project_id' => $notify->project_id,
                'from_user_id' => $notify->chat_from_user_id,
                'from_user_user_name' => $notify->from_user->user_name ?? '',
                'project_slug' => $notify->project->slug ?? '',
                'created_at' => $formattedCreatedAt,
            ];
        });

        return $this->dataResponse(__('msg.notifications_get_success', [], $this->lang), $data, 200);
    }

    public function makeNotifacationRead(Request $request)
    {
        if ($request->type == 1)
            DB::table('notifacations')->where('user_id', $this->user->id)
                ->update(['is_read' => 1]);
        elseif ($request->type == 2)
            DB::table('notifacations')->where('user_id', $this->user->id)
                ->where('id', $request->id)
                ->update(['is_read' => 1]);

        return $this->successResponse(__('msg.notifications_read_success', [], $this->lang), 200);
    }

    public function deleteAccount()
    {
        $user = User::find($this->user->id);
        if ($user)
            $user->delete();
        return $this->successResponse(__('msg.user_deleted_success', [], $this->lang), 200);
    }

    public function skillsList()
    {
        $skills = Skill::get();
        $data = $skills->map(function ($skill) {
            return [
                'id' => $skill->id,
                'name' => $skill->name
            ];
        });

        return $this->dataResponse(__('msg.skills_get_success', [], $this->lang), $data, 200);
    }

    public function createProject(Request $request)
    {
        if ($this->user->user_type != 2)
            return $this->errorResponse(__('msg.account_must_to_be_business_owner', [], $this->lang), 401);
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'desc' => 'required',
            'from_price' => 'required',
            'to_price' => 'required',
            'work_period_days' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails())
            return $this->errorResponse($validator->errors()->first(), 401);

        $project = new Project();
        $project->business_owner_id = $this->user->id;
        $project->title = $request->title;
        $project->desc = $request->desc;
        $project->from_price = $request->from_price;
        $project->to_price = $request->to_price;
        $project->work_period_days = $request->work_period_days;
        $project->category_id = $request->category_id;
        $project->skills = $request->mobile_skills ? $request->mobile_skills : json_encode($request->skills);
        $project->status_id = 1;
        $project->save();

        if ($request->hasFile('files')) {
            foreach ($request->files as $files) {
                foreach ($files as $file)
                    upload_file($file, 0, 'projects', 'App\Models\Project', $project->id, null);

            }
        }

        $msg = $project->id . 'تم اضافة مشروع جديد ';

        $notify = new Notifacations();
        $notify->is_admin = 1;
        $notify->type_id = 1;
        $notify->project_id = $project->id;
        $notify->notify = $msg;
        $notify->save();

        $eventName = 'admin_notification';
        send_pusher_notification($msg, $eventName, 0, $notify->type_id, $notify->project_id, 0);

        return $this->dataResponse(__('msg.project_created_success', [], $this->lang),$project, 200);
    }

    public function contactUs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if ($validator->fails())
            return $this->errorResponse($validator->errors()->first(), 401);

        $message = new ContactUs();
        $message->message = $request->message;
        $message->name = $this->user->name ?? null;
        $message->email = $this->user->email ?? null;
        $message->save();

        $notify = new Notifacations();
        $notify->is_admin = 1;
        $notify->type_id = 2;
        $notify->contact_id = $message->id;
        $notify->notify = $message->message;
        $notify->save();

        $eventName = 'admin_notification';
        send_pusher_notification($notify->notify, $eventName, 0, $notify->type_id, 0, $notify->contact_id);

        return $this->successResponse(__('msg.message_send_success', [], $this->lang), 200);
    }

    public function rateFreelancer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'freelancer_id' => 'required',
            'project_id' => 'required',
            'text' => 'required',
        ]);

        if ($validator->fails())
            return $this->errorResponse($validator->errors()->first(), 401);

        if ($this->user->user_type != 2)
            return $this->errorResponse(__('msg.account_must_to_be_business_owner', [], $this->lang), 401);
        $project = Project::find($request->project_id);
        if (!$project)
            return $this->errorResponse('Project not found', 401);

        $xrate = ProjectRate::where('freelancer_id', $request->freelancer_id)->where('project_id', $project->id)
            ->where('business_owner_id', $this->user->id)->first();
        if ($xrate)
            return $this->errorResponse(__('msg.freelancer_is_already_rated', [], $this->lang), 401);
        $rate = new ProjectRate();
        $rate->business_owner_id = $this->user->id;
        $rate->freelancer_id = $request->freelancer_id;
        $rate->project_id = $project->id;
        $rate->text = $request->text;
        $rate->rate = $request->rate;
        $rate->save();

        $notify = new Notifacations();
        $notify->user_id = $rate->freelancer_id;
        $notify->type_id = 3;
        $notify->project_id = $project->id;
        $notify->notify = $request->rate . 'تم تقييمك ';
        $notify->save();

        $eventName = 'user_notification';
        send_pusher_notification($notify->notify, $eventName, $notify->user_id, $notify->type_id, $notify->project_id, 0);

        $user = User::find($notify->user_id);
        if ($user)
            sendToFcm($user->fcm_token, $notify->notify, 'اشعار جديد من بورد');
        return $this->successResponse(__('msg.project_rated_success', [], $this->lang), 200);
    }

    public function countries()
    {
        $countries = Country::get();
        $data = $countries->map(function ($country) {
            return [
                'id' => $country->id,
                'name' => $country->name,
            ];
        });

        return $this->dataResponse(__('msg.data_get_success', [], $this->lang), $data, 200);
    }

    public function deleteFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return $this->errorResponse($validator->errors()->first(), 401);
        $old_file_id = $request->id;
        $old_file_id_data = \App\Models\Media::find($old_file_id);
        if (!$old_file_id_data)
            return $this->errorResponse('File not found', 401);
        $oldfilename = public_path() . '' . $old_file_id_data->file_path;
        File::delete($oldfilename);
        $old_file_id_data->delete();

        return $this->successResponse(__('msg.file_deleted_success', [], $this->lang), 200);
    }


    public function makeTransaction(Request $request)
    {
        $type = $request->type_id;
        $code = $this->genrateTransactionNumber();
        if ($type == 1) {
            if ($this->user->user_type != 1) //withdraw
                return $this->errorResponse(__('msg.freelancer_not_found', [], $this->lang), 401);
            $freelancer = User::find($this->user->id);
            if ($freelancer->withdrawable_balance < $request->price)
                return $this->errorResponse(__('msg.You_do_not_have_enough_funds_to_withdraw', [], $this->lang), 401);

            $transaction = new Transaction();
            $transaction->freelancer_id = $this->user->id;
            $transaction->type_id = $type;
            $transaction->price = $request->price;
            $transaction->code = $code;
            $transaction->status_id = 1;
            $transaction->save();

            $freelancer->withdrawable_balance = ($freelancer->withdrawable_balance - $transaction->price);
            $freelancer->save();

            return $this->dataResponse(__('msg.transaction_add_success', [], $this->lang), [], 200);
        } elseif ($type == 2) { //deposit

            $data = [
                "order" => [
                    "reference" => $code,
                    "amount" => $request->price,
                    "currency" => "SAR",
                    "name" => $this->user->name,
                ],
                "configuration" => [
                    "locale" => "ar"
                ]
            ];

            $response = NoonPayment::getInstance()->initiate($data);

            $postUrl = isset($response->result->checkoutData) && $response->result->checkoutData->postUrl ? $response->result->checkoutData->postUrl : '';
            return $this->dataResponse('initiate success', $postUrl, 200);
        } elseif ($type == 3) { //Transfer_to_Freelance
            if ($this->user->user_type != 2)
                return $this->errorResponse(__('msg.business_owner_not_found', [], $this->lang), 401);
            $freelancer = User::find($request->freelancer_id);
            $owner = User::find($this->user->id);
            if ($owner->business_owner_palance < $request->price)
                return $this->errorResponse(__('msg.business_owner_palance_is_less', [], $this->lang), 401);

            $owner->business_owner_palance = ($owner->business_owner_palance - $request->price);
            $owner->save();

            $freelancer->pending_balance = ($freelancer->pending_balance + $request->price);
            $freelancer->save();

            $transaction = new Transaction();
            $transaction->freelancer_id = $freelancer->id;
            $transaction->business_owner_id = $owner->id;
            $transaction->type_id = $type;
            $transaction->price = $request->price;
            $transaction->code = $code;
            $transaction->status_id = 2;
            $transaction->save();
            return $this->dataResponse(__('msg.transaction_add_success', [], $this->lang), [], 200);
        } elseif ($type == 4) { //Transfer_to_Freelance
            if ($this->user->user_type != 1)
                return $this->errorResponse('Freelancer not found', 401);
            $freelancer = User::find($this->user->id);
            $owner = User::find($request->business_owner_id);
            if ($freelancer->pending_balance < $request->price)
                return $this->errorResponse(__('msg.freelancer_palance_is_less', [], $this->lang), 401);

            $owner->business_owner_palance = ($owner->business_owner_palance + $request->price);
            $owner->save();

            $freelancer->pending_balance = ($freelancer->pending_balance - $request->price);
            $freelancer->save();

            $transaction = new Transaction();
            $transaction->freelancer_id = $freelancer->id;
            $transaction->business_owner_id = $this->user->id;
            $transaction->type_id = $type;
            $transaction->price = $request->price;
            $transaction->code = $code;
            $transaction->status_id = 2;
            $transaction->save();
            return $this->dataResponse(__('msg.transaction_add_success', [], $this->lang), [], 200);
        }

    }

    public function checkOrderPayment(Request $request)
    {
        $response = NoonPayment::getInstance()->getOrder($request->orderId);
        $code = $this->genrateTransactionNumber();
        if (isset($response->result->transactions[0])) {
            if ($response->result->transactions[0]->type == "SALE" && $response->result->transactions[0]->status == "SUCCESS") {
                $transaction = new Transaction();
                $transaction->business_owner_id = $this->user->id;
                $transaction->type_id = 2;
                $transaction->price = $response->result->transactions[0]->amount;
                $transaction->code = $code;
                $transaction->status_id = 2;
                $transaction->is_payment = 1;
                $transaction->payment = 'Card';
                $transaction->payment_info = json_encode($response);
                $transaction->save();

                $user = User::find($transaction->business_owner_id);
                if ($user) {
                    $user->business_owner_palance = $user->business_owner_palance + $transaction->price;
                    $user->save();
                }
                return $this->successResponse(__('msg.transaction_add_success', [], $this->lang), 200);
            } else {
                return $this->errorResponse(__('msg.transaction_faild', [], $this->lang), 401);
            }
        } else {
            return $this->errorResponse(__('msg.transaction_faild', [], $this->lang), 401);
        }
    }

    public function genrateTransactionNumber()
    {
        do {
            $code = rand(111111, 999999);
            $data = Transaction::where('code', $code)->first();
            if (!$data) return $code;
        } while (true);
    }

    public function addPortfolio(Request $request)
    {
        $id = 0;
        if ($request->id)
            $id = $request->id;

        $portfilo = Portfolio::find($id);
        if (!$portfilo)
            $portfilo = new Portfolio();
        $portfilo->user_id = $this->user->id;
        $portfilo->title = $request->title;
        $portfilo->desc = $request->desc;
        $portfilo->url = $request->url;
        $portfilo->work_date = $request->work_date;
        $portfilo->skills = $request->mobile_skills ? $request->mobile_skills : json_encode($request->skills);
        $portfilo->save();
        if ($request->hasFile('image'))
            upload_file($request->image, 0, 'portfolio', 'App\Models\Portfolio', $portfilo->id, 'portfolio');
        return $this->successResponse(__('msg.portfilo_add_success', [], $this->lang), 200);
    }

    public function deletePortfilo(Request $request)
    {
        $id = 0;
        if ($request->id)
            $id = $request->id;

        $portfilo = Portfolio::find($id);
        if (!$portfilo)
            return $this->errorResponse(__('msg.item_not_found', [], $this->lang));
        $portfilo->delete();

        return $this->successResponse(__('msg.deleted_success', [], $this->lang), 200);
    }

}

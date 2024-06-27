<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projects';

    protected $guarded = [];

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    public function business_owner()
    {
        return $this->belongsTo(User::class, 'business_owner_id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
    public function files()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function offers(){
        return $this->hasMany(ProjectOffer::class,'project_id');
    }

    public function rate(){
        return $this->hasOne(ProjectRate::class,'project_id');
    }
    public function getStatusNameAttribute()
    {
        switch ($this->status_id) {
            case 1:
                return __('msg.open');
            case 2:
                return __('msg.ongoing');
            case 3:
                return __('msg.completed');
            case 4:
                return __('msg.canceled');
        }
    }

    public function api_status_name($lang)
    {
        switch ($this->status_id) {
            case 1:
                return __('msg.open',[],$lang);
            case 2:
                return __('msg.ongoing',[],$lang);
            case 3:
                return __('msg.completed',[],$lang);
            case 4:
                return __('msg.canceled',[],$lang);
        }
    }

    public function getSkillsListAttribute(){
        $arr = [];
        if ($this->skills)
            $arr = Skill::whereIn('id',json_decode($this->skills))->get();
        return $arr;
    }

    public function getPriceBidAttribute(){
        $price = 0;
        if (isset($this->offers) && count($this->offers) > 0){
            $sum_price_offers = $this->offers()->sum('price');
            $price = $sum_price_offers/count($this->offers);
        }
        return (float)$price;
    }

    public function is_business_owner_bay($business_owner_id){
        $is_paid = 0;
        $transaction = Transaction::where('project_id',$this->id)->where('business_owner_id',$business_owner_id)->where('is_payment',1)->first();
        if ($transaction)
            $is_paid = 1;
        return $is_paid;
    }

    public function getTotalProfitAttribute(){
        $setting = Settings::first();
        return $this->work_price * $setting->profit_rate /100;
    }
    public static function boot()
    {
        parent::boot();

        self::saving(function($model){
            if (!$model->slug)
                $model->slug = Str::slug($model->title,'-');
        });

    }

    public function user_offer($user_id){
        $x = 0;
        if (isset($this->offers) && count($this->offers) > 0){
            $data = $this->offers()->where('freelancer_id',$user_id)->first();
            if ($data)
                $x = 1;
        }
        return $x;
    }
}

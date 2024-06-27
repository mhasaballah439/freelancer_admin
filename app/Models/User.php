<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'password',
    ];

    public function image()
    {
        return $this->morphOne(Media::class, 'mediable')->where('type','=','profile_image')->orderBy('id','DESC');
    }

    public function files()
    {
        return $this->morphMany(Media::class, 'mediable')->where('type','=','files')->orderBy('id','DESC');
    }

    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }

    public function portfolio(){
        return $this->hasMany(Portfolio::class,'user_id');
    }

    public function freelancer_rate(){
        return $this->hasMany(ProjectRate::class,'freelancer_id');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    public function getUserTypeNameAttribute()
    {
        switch ($this->user_type) {
            case 1:
                return __('msg.freelancer');
            case 2:
                return __('msg.business_owner');
        }
    }


    public function getStatusNameAttribute()
    {
        switch ($this->status_id) {
            case 1:
                return __('msg.approve');
            case 2:
                return __('msg.suspend');
            case 3:
                return __('msg.not_approve');
        }
    }

    public function getTagsListAttribute(){
        $arr = [];
        if ($this->tags)
            $arr = Tag::whereIn('id',json_decode($this->tags))->get();
        return $arr;
    }

    public function getSkillsListAttribute(){
        $arr = [];
        if ($this->skills)
            $arr = Skill::whereIn('id',json_decode($this->skills))->get();
        return $arr;
    }

    public function getStarsAttribute(){
        $stars = 0;
        if (isset($this->freelancer_rate)){
            $count_rates = $this->freelancer_rate()->count();
            $count_stars = $this->freelancer_rate()->sum('rate');
            if ($count_stars > 0)
                $stars = $count_stars/$count_rates;
        }

        return round($stars,2);
    }

    public function getCompleteTasksAttribute(){
        $count_work_projects = Project::where('freelancer_id',$this->id)->count();
        $count_complete_projects = Project::where('freelancer_id',$this->id)->where('status_id',3)->count();
        $total = 0;
        if ($count_complete_projects > 0) {
            $total = ($count_complete_projects / $count_work_projects) * 100;
        }
        return (float)$total;
    }

    public function getOnTimeAttribute(){
        $count_work_projects = Project::where('freelancer_id',$this->id)->count();
        $count_complete_projects = Project::where('freelancer_id',$this->id)->where('status_id',3)
            ->whereRaw('DATE(end_date) = DATE(updated_at)')->count();
        $total = 0;
        if ($count_complete_projects > 0) {
            $total = ($count_complete_projects / $count_work_projects) * 100;
        }
        return (float)$total;
    }

    public function getAvgWorkDaysAttribute(){
        $sum_days = Project::where('freelancer_id',$this->id)->where('status_id',3)->sum('freelancer_work_days');
        $count_projects = Project::where('freelancer_id',$this->id)->where('status_id',3)->count();
        $total = 0;
        if ($sum_days > 0) {
            $total = ($sum_days / $count_projects) * 100;
        }
        return (float)$total;
    }
}

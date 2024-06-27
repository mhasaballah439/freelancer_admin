<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $guarded = [];

    public function getNameAttribute(){
        if (App::isLocale('ar'))
            return $this->name_ar;
        else
            return $this->name_en;
    }

    public function api_name($lang){
        if ($lang == 'ar')
            return $this->name_ar;
        else
            return $this->name_en;
    }

    public function scopeActive($q){
        return $q->where('active',1);
    }

    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            $model->slug = Str::slug($model->name_ar,'-');
        });

    }
}

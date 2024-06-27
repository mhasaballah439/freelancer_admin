<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'sliders';
    protected $guarded = [];

    public function getTitleAttribute()
    {
        if (App::isLocale('ar'))
            return $this->title_ar;
        else
            return $this->title_en;
    }

    public function api_title($lang)
    {
        if ($lang == 'ar')
            return $this->title_ar;
        else
            return $this->title_en;
    }

    public function getDescAttribute()
    {
        if (App::isLocale('ar'))
            return $this->desc_ar;
        else
            return $this->desc_en;
    }

    public function api_desc($lang)
    {
        if ($lang == 'ar')
            return $this->desc_ar;
        else
            return $this->desc_en;
    }

    public function getBtn2TextAttribute()
    {
        if (App::isLocale('ar'))
            return $this->btn2_text_ar;
        else
            return $this->btn2_text_en;
    }

    public function api_btn2_text($lang)
    {
        if ($lang == 'ar')
            return $this->btn2_text_ar;
        else
            return $this->btn2_text_en;
    }

    public function getBtn1TextAttribute()
    {
        if (App::isLocale('ar'))
            return $this->btn1_text_ar;
        else
            return $this->btn1_text_en;
    }

    public function api_btn1_text($lang)
    {
        if ($lang == 'ar')
            return $this->btn1_text_ar;
        else
            return $this->btn1_text_en;
    }

    public function scopeActive($q)
    {
        return $q->where('active', 1);
    }
}

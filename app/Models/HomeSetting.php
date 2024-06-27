<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class HomeSetting extends Model
{
    use HasFactory;
    protected $table = 'home_settings';
    protected $guarded = [];
    public function files()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
    public function getAppTitleAttribute(){
        if (App::isLocale('ar'))
            return $this->app_title_ar;
        else
            return $this->app_title_en;
    }

    public function api_app_title($lang){
        if ($lang == 'ar')
            return $this->app_title_ar;
        else
            return $this->app_title_en;
    }

    public function getAppDescAttribute(){
        if (App::isLocale('ar'))
            return $this->app_desc_ar;
        else
            return $this->app_desc_en;
    }

    public function api_app_desc($lang){
        if ($lang == 'ar')
            return $this->app_desc_ar;
        else
            return $this->app_desc_en;
    }
    public function getFooterTextAttribute(){
        if (App::isLocale('ar'))
            return $this->footer_text_ar;
        else
            return $this->footer_text_en;
    }

    public function api_footer_text($lang){
        if ($lang == 'ar')
            return $this->footer_text_ar;
        else
            return $this->footer_text_en;
    }

}

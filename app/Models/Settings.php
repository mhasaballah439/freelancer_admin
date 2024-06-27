<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Settings extends Model
{
    use HasFactory;
    protected $table = 'settings';
    protected $guarded = [];

    public function getAboutUsAttribute(){
        if (App::isLocale('ar'))
            return $this->about_us_ar;
        else
            return $this->about_us_en;
    }

    public function getTermsConditionsAttribute(){
        if (App::isLocale('ar'))
            return $this->terms_conditions_ar;
        else
            return $this->terms_conditions_en;
    }

    public function getPolicyAttribute(){
        if (App::isLocale('ar'))
            return $this->policy_ar;
        else
            return $this->policy_en;
    }



}

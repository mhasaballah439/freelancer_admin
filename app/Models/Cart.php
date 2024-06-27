<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $guarded = [];

    public function file()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');
    }
    public function getPaperTypeNameAttribute(){
        switch ($this->paper_type){
            case 1:
                return __('msg.normal');
                case 2:
                return __('msg.bright');
                case 3:
                return __('msg.adhesive');
                case 4:
                return __('msg.reinforced');
        }
    }
    public function getPageLayoutNameAttribute(){
        switch ($this->page_layout){
            case 1:
                return __('msg.auto_width_and_length');
                case 2:
                return __('msg.two_strips_with_longitudinal_leaf');
                case 3:
                return __('msg.4_longitudinal_slices');
                case 4:
                return __('msg.two_slats_with_a_transverse_leaf');
                case 5:
                return __('msg.4_strips_of_transverse_paper');
        }
    }
    public function getAspectsPrintingNameAttribute(){
        switch ($this->aspects_printing){
            case 1:
                return __('msg.face');
                case 2:
                return __('msg.two_face');
        }
    }
    public function getPackagingNameAttribute(){
        switch ($this->packaging_id){
            case 1:
                return __('msg.without_packaging');
                case 2:
                return __('msg.transparent_bag');
                case 3:
                return __('msg.corner_stapling');
                case 4:
                return __('msg.side_staple');
                case 5:
                return __('msg.wire');
                case 6:
                return __('msg.spiral_plastic');
                case 7:
                return __('msg.stud_heel');
                case 8:
                return __('msg.thermal_heel');
                case 9:
                return __('msg.kharmin_file');
                case 10:
                return __('msg.file_3_perforated');
                case 11:
                return __('msg.stitching');
        }
    }
    public function aspects_printing_name($lang){
        switch ($this->aspects_printing){
            case 1:
                return __('msg.face',[],$lang);
            case 2:
                return __('msg.two_face',[],$lang);
        }
    }
    public function paper_type_name($lang){
        switch ($this->paper_type){
            case 1:
                return __('msg.normal',[],$lang);
                case 2:
                return __('msg.bright',[],$lang);
                case 3:
                return __('msg.adhesive',[],$lang);
                case 4:
                return __('msg.reinforced',[],$lang);
        }
    }
    public function page_layout_name($lang){
        switch ($this->page_layout){
            case 1:
                return __('msg.auto_width_and_length',[],$lang);
                case 2:
                return __('msg.two_strips_with_longitudinal_leaf',[],$lang);
                case 3:
                return __('msg.4_longitudinal_slices',[],$lang);
                case 4:
                return __('msg.two_slats_with_a_transverse_leaf',[],$lang);
                case 5:
                return __('msg.4_strips_of_transverse_paper',[],$lang);
        }
    }
    public function packaging_name($lang){
        switch ($this->packaging_id){
            case 1:
                return __('msg.without_packaging',[],$lang);
                case 2:
                return __('msg.transparent_bag',[],$lang);
                case 3:
                return __('msg.corner_stapling',[],$lang);
                case 4:
                return __('msg.side_staple',[],$lang);
                case 5:
                return __('msg.wire',[],$lang);
                case 6:
                return __('msg.spiral_plastic',[],$lang);
                case 7:
                return __('msg.stud_heel',[],$lang);
                case 8:
                return __('msg.thermal_heel',[],$lang);
                case 9:
                return __('msg.kharmin_file',[],$lang);
                case 10:
                return __('msg.file_3_perforated',[],$lang);
                case 11:
                return __('msg.stitching',[],$lang);
        }
    }

    public function getSubTotalAttribute(){
        return $this->price * $this->qty;
    }

    public function getTaxPriceAttribute(){
        $setting = Settings::first();
        return $this->sub_total * $setting->tax/100;
    }

    public function getTotalAttribute(){
        $first_page_color_price = 0;
        $setting = Settings::first();

        return $this->sub_total + $this->tax_price + $this->color_cover_price;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    public function business_owner()
    {
        return $this->belongsTo(User::class, 'business_owner_id');
    }

    public function getTypeNameAttribute()
    {
        switch ($this->type_id) {
            case 1:
                return __('msg.withdraw');
            case 2:
                return __('msg.deposit');
            case 3:
                return __('msg.Transfer_to_Freelance');
            case 4:
                return __('msg.Transfer_from_Freelance_to_business_owner');
        }
    }

    public function getStatusNameAttribute()
    {
        switch ($this->status_id) {
            case 1:
                return __('msg.pending');
            case 2:
                return __('msg.approved');
            case 3:
                return __('msg.rejected');
        }
    }

    public function api_status_name($lang)
    {
        switch ($this->status_id) {
            case 1:
                return __('msg.pending',[],$lang);
            case 2:
                return __('msg.approved',[],$lang);
            case 3:
                return __('msg.rejected',[],$lang);
        }
    }
}

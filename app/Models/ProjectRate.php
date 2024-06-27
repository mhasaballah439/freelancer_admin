<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRate extends Model
{
    use HasFactory;

    protected $table = 'project_rates';
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectOffer extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'project_offers';
    protected $guarded = [];

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }
    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    public function files()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPermitions extends Model
{
    use HasFactory;
    protected $table = 'admin_permitions';
    protected $guarded = [];

    public function link(){
        return $this->belongsTo(Links::class,'link_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifacations extends Model
{
    use HasFactory;
    protected $table = 'notifacations';
    protected $guarded = [];

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }

    public function from_user(){
        return $this->belongsTo(User::class,'chat_from_user_id');
    }
    public function getTypeNameAttribute(){
        switch ($this->type_id){
            case 1:
                return __('project');
                case 2:
                return __('contact_us');
                case 3:
                return __('rate');
                case 4:
                return __('chat');
        }
    }
}

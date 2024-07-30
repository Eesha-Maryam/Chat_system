<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mails extends Model
{
    use HasFactory;
    public function sender(){
        return $this->belongsto(User::class,'sender_id');
    }
    public function reciever(){
        return $this->belongsto(User::class,'reciever_id');
    }
}

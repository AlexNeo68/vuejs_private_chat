<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['content'];

    public function chats(){
       return $this->hasMany(Chat::class);
    }

    public function session() {
       return $this->belongsTo(Session::class);
    }
}

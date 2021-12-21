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

    public function chatForSender($session_id) {
        return $this->chats()->create([
            'session_id' => $session_id,
            'user_id' => auth()->user()->id,
            'type' => 0
        ]);
    }

    public function chatForRecepient($session_id, $user_to) {
        return $this->chats()->create([
            'session_id' => $session_id,
            'user_id' => $user_to,
            'type' => 1
        ]);
    }
}

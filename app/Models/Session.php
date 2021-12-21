<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = ['user1_id', 'user2_id'];

    public $timestamps = false;

    public function chats(){
       return $this->hasManyThrough(Chat::class, Message::class);
    }

    public function messages() {
       return $this->hasMany(Message::class);
    }

    public function delete_chats(){
       return $this->chats()
            ->whereUserId(auth()->user()->id)
            ->delete();
    }

    public function delete_messages(){
       return $this->messages()->delete();
    }

    public function block(){
        $this->block = 1;
        $this->blocked_by = auth()->user()->id;
        $this->save();
        return $this;
    }

    public function unblock(){
        $this->block = 0;
        $this->blocked_by = null;
        $this->save();
        return $this;
    }
}

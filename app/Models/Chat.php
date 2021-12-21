<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{

    use HasFactory;

    public $dates = ['read_at'];

    protected $fillable = [
        'message_id',
        'session_id',
        'user_id',
        'read_at',
        'type',
    ];

    public function message(){
        return $this->belongsTo(Message::class);
    }
}

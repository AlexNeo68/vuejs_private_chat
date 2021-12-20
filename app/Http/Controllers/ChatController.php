<?php

namespace App\Http\Controllers;

use App\Models\Session;

class ChatController extends Controller
{
    public function send(Session $session) {
        if(request()->has('content')){
            $message = $session->messages()->create([
                'content' => request('content')
            ]);

            return $message;
        }
       return false;
    }
}

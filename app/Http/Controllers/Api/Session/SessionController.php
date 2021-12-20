<?php

namespace App\Http\Controllers\Api\Session;

use App\Http\Controllers\Controller;
use App\Http\Resources\SessionResource;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function store() {
        $session = Session::create([
            'user1_id' => auth()->user()->id,
            'user2_id' => request('friend_id'),
        ]);
       return new SessionResource($session);
    }
}

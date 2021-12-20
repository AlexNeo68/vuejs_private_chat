<?php

namespace App\Http\Controllers\Api\Friends;

use App\Http\Controllers\Controller;
use App\Http\Resources\Friends\FriendResource;
use App\Models\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function index() {
       return FriendResource::collection(User::where('id', '!=', auth()->user()->id)->get());
    }
}

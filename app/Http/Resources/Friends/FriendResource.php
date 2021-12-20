<?php

namespace App\Http\Resources\Friends;

use App\Models\Session;
use App\Http\Resources\SessionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FriendResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'session' => $this->session_details($this->id)
        ];
    }

    protected function session_details($id){
        $session = Session::whereIn('user1_id', [$id, auth()->user()->id])
            ->whereIn('user2_id', [$id, auth()->user()->id])->first();
        return new SessionResource($session);
    }
}

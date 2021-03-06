<?php

namespace App\Http\Resources;

use App\Models\Session;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
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

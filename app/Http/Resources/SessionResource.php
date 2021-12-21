<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
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
            'open' => false,
            'block' => !!$this->block,
            'blocked_by' => (int) $this->blocked_by,
            'users' => [$this->user1_id, $this->user2_id],
            'unread_chats_count' => $this->chats()
                    ->whereReadAt(null)
                    ->whereType(0)
                    ->where('user_id', '!=', auth()->user()->id)
                    ->get()
                    ->count()
        ];
    }
}

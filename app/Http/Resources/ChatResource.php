<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
            'session_id' => $this->session_id,
            'message' => $this->message->content,
            'type' => $this->type,
            'read_at' => optional($this->read_at)->diffForHumans(),
            'send_at' => $this->created_at->diffForHumans(),
        ];
    }
}

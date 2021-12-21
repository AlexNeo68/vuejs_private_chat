<?php

namespace App\Http\Controllers;

use App\Events\MessageReadEvent;
use App\Events\PrivateChatEvent;
use App\Http\Requests\SendMessageRequest;
use App\Http\Resources\ChatResource;
use App\Models\Session;

class ChatController extends Controller
{
    public function send(SendMessageRequest $request, Session $session) {

        $message = $session->messages()->create([
            'content' => request('content')
        ]);

        $chat = $message->chatForSender($session->id);
        $message->chatForRecepient($session->id, request('user_to'));

        broadcast(new PrivateChatEvent(new ChatResource($chat)));

        return new ChatResource($chat);
    }

    public function chats(Session $session) {
       $chats = $session->chats()
            ->with('message')
            ->whereUserId(auth()->user()->id)
            ->get();

        return ChatResource::collection($chats);
    }

    public function read(Session $session) {
       $chats = $session->chats()
        ->whereReadAt(null)
        ->whereType(0)
        ->where('user_id', '!=', auth()->user()->id)
        ->get();

        foreach ($chats as $chat) {
            $chat->read_at = now();
            $chat->save();
            broadcast(new MessageReadEvent(new ChatResource($chat)));
        }

        return $chats;
    }

    public function clear(Session $session) {

        $session->delete_chats();
        if(!$session->chats->count()){
            $session->delete_messages();
        }

        return response([], 204);
    }


}

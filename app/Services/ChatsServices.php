<?php

namespace App\Services;

use App\Http\Controllers\Api\UserController;
use App\Http\Requests\Api\MessageRequest;
use App\Http\Resources\Api\ConversationResource;
use App\Http\Resources\Api\UserResource;
use App\Models\ConversationParticipants;
use App\Models\Conversations;
use App\Models\Messages;
use App\Models\User;
use App\Traits\ApiResponseTrait;

class ChatsServices
{
    // ? return user contacts chats
    public static function userContacts()
    {
        $user = auth()->user();
        if ($user) {
            $contactUsers = $user->contacts->map(function ($contact) {
                return $contact->contact;
            });
            return UserResource::collection($contactUsers);
        }
    }

    // ?get all convs and current conv (one or all)
    public static function getConversations($conv_id = null)
    {
        $user = auth()->user();
        if ($user) {
            $user = User::with('conversations.participants.user')->find(auth()->id());
            $user_conversations = $user->conversations->flatMap(function ($conv) use($conv_id) {
                return $conv->participants
                    ->when($conv_id, function($query) use($conv_id){
                        return $query->where('conversation_id', $conv_id);
                    })
                    ->where('user_id', '!=', auth()->id())
                    ->map(function($participant) use($conv){
                        return [
                            "user" => $participant->user,
                            "conversation_id" => $conv->id
                        ];
                    });
            })->unique(fn($item) => $item['conversation_id'])->values();
            return ConversationResource::collection($user_conversations);
        }
    }

    public static function sendMessage($data)
    {
        $user = auth()->user();
        if ($user) {
            if ($data) {
                $conv = $user->participants->map(function ($vgt) use ($data) {
                    return $vgt->whereIn('user_id', [auth()->id(), $data['sender_id']])
                    ->select('conversation_id')
                    ->first();
                });
                if($data["conversation_id"] == $conv[0]->conversation_id){
                    $msg = Messages::create($data);
                    return $msg;
                }else{
                    return ApiResponseTrait::Failed("Wrong Conversation", 404);
                }
            }
        }
    }


}

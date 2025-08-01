<?php

namespace App\Services;

use App\Http\Controllers\Api\UserController;
use App\Http\Requests\Api\MessageRequest;
use App\Http\Resources\Api\UserResource;
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

    public static function sendMessage($data)
    {
        $user = auth()->user();
        if ($user) {
            if ($data) {
                $conversation = Conversations::where('created_by', $user->id);

                $message = Messages::create($data);
                return $message;
            }
        }
    }

    public static function getAllConversations()
    {
        $user = auth()->user();
        if ($user) {
            $user = User::with('conversations.participants.user')->find(auth()->id());
            $user_conversations = $user->conversations->flatMap(function ($conv) {
                return $conv->participants
                    ->where('user_id', '!=', auth()->id())
                    ->pluck('user');
            })->unique('id')->values();
            return UserResource::collection($user_conversations);
        }
    }
}

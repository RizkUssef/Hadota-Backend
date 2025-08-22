<?php

namespace App\Services;

use App\Http\Controllers\Api\UserController;
use App\Http\Requests\Api\MessageRequest;
use App\Http\Resources\Api\ConversationResource;
use App\Http\Resources\Api\MessageResource;
use App\Http\Resources\Api\UserResource;
use App\Models\ConversationParticipants;
use App\Models\Conversations;
use App\Models\Messages;
use App\Models\MessageStatuses;
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
            $user_conversations = $user->conversations->flatMap(function ($conv) use ($conv_id) {
                return $conv->participants
                    ->when($conv_id, function ($query) use ($conv_id) {
                        return $query->where('conversation_id', $conv_id);
                    })
                    ->where('user_id', '!=', auth()->id())
                    ->map(function ($participant) use ($conv) {
                        return [
                            "sender_id" => auth()->id(),
                            "recipient_user" => $participant->user,
                            "conversation_id" => $conv->id
                        ];
                    });
            })->unique(fn($item) => $item['conversation_id'])->values();
            return ConversationResource::collection($user_conversations);
        }
    }
    public static function getConversationsParticipants()
    {
        $user = auth()->user();
        if ($user) {
            $user = User::with('conversations.participants.user')->find(auth()->id());
            $user_conversations = $user->participants
                ->flatMap(function ($part) {
                    return $part->conversation->participants
                        ->where('user_id', '!=', auth()->id())
                        ->map(fn($p) => [
                            "sender_id"       => auth()->id(),
                            "recipient_user"  => $p->user,
                            "conversation_id" => $part->conversation_id,
                        ]);
                })
                ->unique(fn($item) => $item['conversation_id'])
                ->values();
            return ConversationResource::collection($user_conversations);
        }
    }

    public static function sendMessage($data)
    {
        $user = auth()->user();
        if ($user) {
            if ($data) {
                $recipient_id = null;
                $conv = $user->participants->map(function ($participant) use ($data, &$recipient_id) { //& here to allow to make any update of the value of the recipient_id in side the map scope
                    $recipient_id = $participant->select("user_id")
                        ->where('user_id', "!=", $data['sender_id'])
                        ->where('conversation_id', $data["conversation_id"])
                        ->first();
                    // dd($recipient_id?->user_id);
                    return $participant->whereIn('user_id', [auth()->id(), $data['sender_id']])
                        ->where('conversation_id', $data["conversation_id"])
                        ->select('conversation_id')
                        ->first();
                });
                // dd($conv[0]->conversation_id);
                if ($data["conversation_id"] == $conv[0]->conversation_id) {
                    $msg = Messages::create($data);
                    MessageStatuses::create([
                        "message_id" => $msg->id,
                        "user_id" => $recipient_id?->user_id,
                    ]);
                    return $msg;
                } else {
                    return ApiResponseTrait::Failed("Wrong Conversation", 404);
                }
            }
        }
    }

    // ?get msgs
    public static function getMessages($conv_id)
    {
        $user = auth()->user();
        if ($user) {
            $messages = Messages::where("conversation_id", $conv_id)->get();
            return MessageResource::collection($messages);
        }
    }
}

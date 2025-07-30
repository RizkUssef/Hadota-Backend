<?php

namespace App\Services;

use App\Http\Requests\Api\MessageRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\Conversations;
use App\Models\Messages;

class ChatsServices{
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

    public static function sendMessage($data){
        $user = auth()->user();
        if ($user) {
            if($data){
                $conversation = Conversations::where('created_by',$user->id);

                $message = Messages::create($data);
                return $message;
            }
        }
    }

    public static function getAllConversations(){
        $user = auth()->user();
        if ($user) {
            $convs = Conversations::where('created_by',auth()->id())->get();
            return $convs;
            // return $convs[0]->creator;
            // return $convs[0]->messages;
            // $msg = Messages::with(['conversation', 'statuses'])
            // ->where("sender_id" , $user->id)
            // ->whereHas("statuses",fn($q) => $q->where('status', "delivered"))
            // ->get();
        }
    }
}
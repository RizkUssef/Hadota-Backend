<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MessageRequest;
use App\Models\Conversations;
use App\Services\ChatsServices;
use App\Services\UserServices;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class ChatController extends Controller
{
    //? return all contacts
    public function userContacts()
    {
        $contacts = ChatsServices::userContacts();
        if (!empty($contacts)) {
            return ApiResponseTrait::Success($contacts, "your contacts returned successfully");
        }else{
            return ApiResponseTrait::Failed("No contacts Found", 404);
        }
    }

    // ? get current chat 
    public function currentChat($id)
    {
        $user = UserServices::getUserWithId($id);
        if ($user) {
            return ApiResponseTrait::Success($user, "data returned successfully");
        } else {
            return ApiResponseTrait::Failed("No user Found", 404);
        }
    }

    // ? get the all conversation and current conv
    public function getConversations($id = null){
        $convs = ChatsServices::getConversations($id);
        if($convs){
            return ApiResponseTrait::Success($convs, "data returned successfully");
        }else{
            return ApiResponseTrait::Failed("No data found", 404);
        }
    }


    public function sendMessage(MessageRequest $request)
    {
        $data = $request->validated();
        $message = ChatsServices::sendMessage($data);
        if($message){
            return ApiResponseTrait::Success($message, "message sent successfully");
        }else{
            return ApiResponseTrait::Failed("failed to send message",404);
        }
    }
}

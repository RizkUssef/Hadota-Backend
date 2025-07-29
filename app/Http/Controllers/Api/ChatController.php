<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MessageRequest;
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
        $contacts = ChatsServices::getUserChats();
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

    public function sendMessage(MessageRequest $request){
        $data = $request->validated();
        // add the conv id and user id
        $data[]
        $message = ChatsServices::sendMessage($data);
        return ApiResponseTrait::Success($message, "message sent successfully");
    }
}

<?php

namespace App\Services;

use App\Http\Requests\Api\GetUserByEmail;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\ContactResource;
use App\Http\Resources\Api\UserResource;
use App\Models\Contacts;
use App\Models\ConversationParticipants;
use App\Models\Conversations;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

use function PHPSTORM_META\map;

class UserServices
{
    public static function create($data)
    {
        $user = User::create($data);
        return $user;
    }

    public static function getUser()
    {
        if (auth()->user()) {
            return  UserResource::collection(collect([auth()->user()]));
        }
    }

    public static function getUserWithId($id)
    {
        if ($id) {
            $user = User::findOrFail($id);
            return  UserResource::collection(collect([$user]));
        }
    }

    public static function getAllUsers()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public static function getUserByEmail($email)
    {
        $user = User::where("email", $email)->first();
        return $user;
        // return UserResource::collection(collect([$user]));
    }
    public static function getUserByUserName($username)
    {
        // dd(["user"=>$username]);
        $user = User::where("username", $username)->first();
        return $user;
        // return UserResource::collection(collect([$user]));
    }

    public static function addContact($email = null, $username = null)
    {
        $contact_user = null;
        if ($email != null) {
            $contact_user = self::getUserByEmail($email);
        } elseif ($username != null) {
            $contact_user = self::getUserByUserName($username);
        }
        return self::addContactHandle($contact_user);
    }

    public static function addContactHandle($contact_user)
    {
        if ($contact_user) {
            $user = auth()->user();
            if ($user->contacts->contains('contact_id', $contact_user->id)) {
                return ApiResponseTrait::Failed("This user is already in your contacts", 400);
            } else {
                if ($user->id === $contact_user->id) {
                    return ApiResponseTrait::Failed("You can't add yourself as a contact", 400);
                } else {
                    $contact = Contacts::create([
                        "user_id" => auth()->id(),
                        "contact_id" => $contact_user->id,
                        "nickname" => $contact_user->username,
                        "blocked" => 0
                    ]);
                    $contact_return = ContactResource::collection(collect([$contact]));
                    return ApiResponseTrait::Success($contact_return, "contact added successfully");
                }
            }
        } else {
            return ApiResponseTrait::Failed("contact not found", 400);
        }
    }

    public static function addContactToConversation($contact_id)
    {
        $user = auth()->user();
        if ($user) {
            $contact = Contacts::select("contact_id", "nickname")->where("contact_id", $contact_id)->first();
            try {
                $conv = Conversations::create([
                    "type" => "private",
                    "created_by" => $user->id,
                    "name" => $contact->nickname,
                ]);
                $conv_part = ConversationParticipants::insert([
                    [
                        "conversation_id" => $conv->id,
                        "user_id" => $contact->contact_id,
                    ],
                    [
                        "conversation_id" => $conv->id,
                        "user_id" => $user->id,
                    ],
                ]);
                return true;
                // return ApiResponseTrait::Success("","conversation added successfully");
            } catch (QueryException $e) {
                // dd($e);
                return false;
            }
        }
    }

    public static function update(User $user, $data)
    {
        if ($user) {
            $user->update($data);
            return new UserResource($user);
        } else {
            return ApiResponseTrait::Failed("user not found", 400);
        }
    }

    public static function delete($id)
    {
        return User::destroy($id);
    }

    public static function paginate($nums)
    {
        $users = User::paginate(15);
        return $users;
    }

public static function joinPresenceChannel()
{
    auth()->user()->update(['status' => 'online']);
}
}

<?php

namespace App\Services;

use App\Http\Requests\Api\GetUserByEmail;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\ContactResource;
use App\Http\Resources\Api\UserResource;
use App\Models\Contacts;
use App\Models\User;
use App\Traits\ApiResponseTrait;
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
    public static function getUserByUserName($user_name)
    {
        // dd(["user"=>$user_name]);
        $user = User::where("user_name", $user_name)->first();
        return $user;
        // return UserResource::collection(collect([$user]));
    }

    public static function addContact($email = null, $user_name = null)
    {
        $contact_user = null;

        if ($email != null) {
            $contact_user = self::getUserByEmail($email);
        } elseif ($user_name != null) {
            $contact_user = self::getUserByUserName($user_name);
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
                        "nickname" => $contact_user->user_name,
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

    // ? return user contacts chats
    public static function getUserChats()
    {
        $user = auth()->user();
        if ($user) {
            $contactUsers = $user->contacts->map(function ($contact) {
                return $contact->contact;
            });
            return UserResource::collection($contactUsers);
        }
    }

    public static function update(User $user, $data)
    {
        // $user = auth()->user();
        if ($user) {
            // dd($data);
            $user->update($data);
            // dd($user);
            // return $user;
            return new UserResource($user);

            // return UserResource::collection(collect($user));
        } else {
            return ApiResponseTrait::Failed("user not found", 400);
        }
    }

    public static function delete($id)
    {
        // $user = User::findOrFail($id);
        // $user_deleted = $user->delete();
        // return $user_deleted;
        return User::destroy($id);
    }

    public static function paginate($nums)
    {
        $users = User::paginate(15);
        return $users;
    }
}

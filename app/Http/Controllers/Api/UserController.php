<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddContactRequest;
use App\Http\Requests\Api\GetUserByEmail;
use App\Http\Requests\Api\GetUserByUserName;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\UserUpdateRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Services\UserServices;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = UserServices::getUser();
        if ($user) {
            return ApiResponseTrait::Success($user, "data returned successfully");
        }else{
            return ApiResponseTrait::Failed("No user Found", 404);
        }
    }

    public function allUsers(){
        $users = UserServices::getAllUsers();
        if ($users) {
            return ApiResponseTrait::Success($users, "data returned successfully");
        } else {
            return ApiResponseTrait::Failed("No user Found", 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = UserServices::create($data);
        return ApiResponseTrait::Success($user, "user inserted successfully");
    }

    public function userChats()
    {
        $contacts = UserServices::getUserChats();
        if ($contacts) {
            return ApiResponseTrait::Success($contacts, "your contacts returned successfully");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUser(UserUpdateRequest $request)
    {
        $user = auth()->user();

        $data = $request->validated();

        if ($request->hasFile('avatar_url')) {
            if ($user->avatar_url && Storage::disk("public")->exists($user->avatar_url)) {
                Storage::disk('public')->delete($user->avatar_url);
            }
            $data['avatar_url']  = $request->file('avatar_url')->store('Uploads/Users Avatar', 'public');
        }
        $user = UserServices::update($user, $data);
        return ApiResponseTrait::Success($user, "user updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function addContact(AddContactRequest $request)
    {
        $user = $request->validated();
        if ($request->input("email") && $user["email"]) {
            return UserServices::addContact($user);
        } elseif ($request->input("user_name") && $user["user_name"]) {
            return UserServices::addContact("", $user);
        }
    }
}

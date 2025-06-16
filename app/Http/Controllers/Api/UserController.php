<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetUserByEmail;
use App\Http\Requests\Api\GetUserByUserName;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\Api\UserResource;
use App\Services\UserServices;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $users =auth()->user();
        // $user = JWTAuth::parseToken()->authenticate();
        // dd($user);
        $users = UserServices::getUser();
        if ($users) {
            return ApiResponseTrait::Success($users, "data returned successfully");
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

    /**
     * Display the specified resource.
     */
    // public function show()
    // {
    //     $user = UserServices::getUser();
    //     dd($user);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function addContactByEmail(GetUserByEmail $request)
    {
        $email = $request->validated();
        return UserServices::addContact($email);
    }

    public function addContactByUserName(GetUserByUserName $request)
    {
        $user_name = $request->validated();
        return UserServices::addContact("", $user_name);
    }
}

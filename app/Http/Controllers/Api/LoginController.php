<?php

namespace App\Http\Controllers\Api;

use App\Events\ChangeUserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\UserResource;
use App\Services\UserServices;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if (JWTAuth::attempt($data)) {
            $token = JWTAuth::attempt($data);
            return ApiResponseTrait::Success(["token" => $token, "user" => UserResource::collection(collect([Auth::user()]))], "logged in successfully", 200);
        } else {
            return ApiResponseTrait::Failed("Unauthorized Wrong Creditainals", 401);
        }
    }
}

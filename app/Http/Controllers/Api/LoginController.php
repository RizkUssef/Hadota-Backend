<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login(LoginRequest $request) {
        $data = $request->validated();
        if(JWTAuth::attempt($data)){
            $token = JWTAuth::attempt($data);
            return ApiResponseTrait::Success(["token"=>$token],"logged in successfully",200);
        }else{
            return ApiResponseTrait::Failed( "Unauthorized Wrong Creditainals",401);
        }
    }
}

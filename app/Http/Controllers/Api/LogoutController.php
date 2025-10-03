<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutController extends Controller
{
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return ApiResponseTrait::Success([], "Logged out successfully", 200);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ApiResponseTrait::Failed("Failed to logout, token may be invalid", 500);
        }
    }
}

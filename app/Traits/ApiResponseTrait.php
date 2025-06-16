<?php

namespace App\Traits;

class ApiResponseTrait{
    public static function Success($data = "", $message = "", $code = 200){
        return response()->json([
            'status' => 'success',
            "message" => $message,
            "data" => $data,
        ],$code);
    }

    public static function Failed($message = "", $code = 400, $errors = null){
        return response()->json([
            'status' => 'error',
            "message" => $message,
            "errors" =>  $errors ?? $message
        ],$code);
    }
}
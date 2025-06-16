<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // "email" => "required|email|exists:users,email",
            "email" => "required|email",
            "password" => "required|min:8"
        ];
    }

    public function messages(){
        return [
            "email.required" => "email field is required",
            "email.email" => "enter vaild email",
            "password.required" => "password field is required",
            "password.min" => "password must be 8 digits"
        ];
    }
}

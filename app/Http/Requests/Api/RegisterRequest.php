<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Contracts\Validation\Validator;
// use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            "user_name" => "required|string|max:40|unique:users,user_name",
            "email"=> "required|email|unique:users,email",
            "password"=> "required|min:8|confirmed",
            "password_confirmation" =>"required"
        ];
    }

    public function messages()
    {
        return [
            "user_name.required" => "user name field is required",
            "user_name.unique" => "The user name has already been taken",
            "user_name.string" => "user name must be string",
            "user_name.max" => "The name cannot exceed 40 characters",
            "email.required" => "email field is required",
            "email.email" => "enter vaild email",
            "email.unique" => "The email has already been taken",
            "password.required" => "password field is required",
            "password.min" => "password must be 8 digits",
            "password.confirmed" => "password must be confirmed",
            "password_confirmation.required"=> "password_confirmation field is required"
        ];
    }

    // protected function failedValidation(Validator $validator)
    // {
    //     // Return the translated custom messages
    //     throw new HttpResponseException(
    //         $this->validationError($validator->errors()->toArray())
    //     );
    // }
}

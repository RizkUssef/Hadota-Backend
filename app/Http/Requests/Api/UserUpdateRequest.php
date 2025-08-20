<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            "username" => "sometimes|string|max:40",
            "avatar_url" => "sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:9216"
        ];
    }

    public function messages()
    {
        return [
            "username.sometimes" => "enter user name field",
            "username.unique" => "The user name has already been taken",
            "username.string" => "user name must be string",
            "username.max" => "The name cannot exceed 40 characters",
            "avatar_url.image" => "file must be an image type",
            "avatar_url.mimes" => "invaild file type",
            "avatar_url.max" => "large file size"
        ];
    }
}

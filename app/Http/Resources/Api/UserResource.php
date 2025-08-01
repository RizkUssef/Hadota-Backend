<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_name" => $this->user_name,
            "email" => $this->email,
            "avatar_url" => $this->avatar_url,
            "status" => $this->status,
            "last_seen_at" => $this->last_seen_at,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "message_id"=>$this->message_id,
            "user_id"=>$this->user_id,
            "status"=>$this->status,
            "updated_at"=>$this->updated_at
        ];
    }
}

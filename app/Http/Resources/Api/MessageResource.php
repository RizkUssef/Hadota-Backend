<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
        "conversation_id" => $this->conversation_id,
        "senderId" => $this->sender_id,
        "content" => $this->content,
        "message_type" => $this->message_type,
        "message_status"=>MessageStatusResource::collection($this->whenLoaded("statuses"))
        ];
    }
}

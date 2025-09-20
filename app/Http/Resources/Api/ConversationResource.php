<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'sender_id' => $this['sender_id'],
            'recipient_user' => new UserResource($this['recipient_user']),
            'conversation_id' => $this['conversation_id'],
            'unread_message_count' => $this['unread_message_count'],
            'last_message' => $this['last_message']
        ];
    }
}

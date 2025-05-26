<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConversationParticipants extends Model
{
    public $timestamps = false;
    protected $fillable = ['conversation_id', 'user_id', 'joined_at', 'role'];

    public function conversation()
    {
        return $this->belongsTo(Conversations::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

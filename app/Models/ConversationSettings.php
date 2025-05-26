<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConversationSettings extends Model
{
    public $timestamps = false;
    protected $fillable = ['conversation_id', 'user_id', 'is_muted', 'is_pinned', 'custom_notification_sound'];

    public function conversation()
    {
        return $this->belongsTo(Conversations::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

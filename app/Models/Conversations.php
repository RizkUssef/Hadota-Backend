<?php

namespace App\Models;

use GuzzleHttp\Psr7\Message;
use Illuminate\Database\Eloquent\Model;

class Conversations extends Model
{
    protected $fillable = ['type', 'created_by', 'name'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants()
    {
        return $this->hasMany(ConversationParticipants::class, "conversation_id");
    }

    public function messages()
    {
        return $this->hasMany(Messages::class,'conversation_id');
    }

    public function settings()
    {
        return $this->hasMany(ConversationSettings::class);
    }
}

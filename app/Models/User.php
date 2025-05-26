<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use GuzzleHttp\Psr7\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password_hash',
        'avatar_url',
        'status',
        'last_seen_at'
    ];

    public function conversations()
    {
        return $this->hasMany(Conversations::class, 'created_by');
    }

    public function participants()
    {
        return $this->hasMany(ConversationParticipants::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contacts::class);
    }
}

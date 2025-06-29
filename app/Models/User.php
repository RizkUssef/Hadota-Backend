<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Casts\DateFormateCast;
use GuzzleHttp\Psr7\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_name',
        'email',
        'password',
        'avatar_url',
        'status',
        'last_seen_at'
    ];

    // * use custum casts to return the created at and updated at in y-m-d format 
    protected $casts =[
        "created_at" => DateFormateCast::class,
        "updated_at" => DateFormateCast::class,
        // "updated_at" => DateFormateCast::class.':short',
    ];
    
    // * mutator function to hash the pass 
    public function setPasswordAttribute($value){
        $this->attributes["password"] = Hash::make($value);
    }

    // * jwt funcs
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
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
        return $this->hasMany(Contacts::class,"user_id");
    }

    
}

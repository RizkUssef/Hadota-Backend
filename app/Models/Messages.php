<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Messages extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'message_type',
        'edited_at'
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversations::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function statuses()
    {
        return $this->hasMany(MessageStatuses::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachments::class);
    }
}

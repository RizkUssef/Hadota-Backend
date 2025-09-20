<?php

namespace App\Models;

use App\Casts\DateFormateCast;
use App\Casts\TimeFormateCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Type\Time;

class Messages extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'message_type',
        'edited_at',
        'created_at',
        'updated_at'
    ];
        protected $casts =[
        "created_at" => DateFormateCast::class,
        "updated_at" => DateFormateCast::class,
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
        return $this->hasMany(MessageStatuses::class,"message_id");
    }

    public function attachments()
    {
        return $this->hasMany(Attachments::class);
    }
}

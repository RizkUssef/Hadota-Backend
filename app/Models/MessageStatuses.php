<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageStatuses extends Model
{
    public $timestamps = false;
    protected $fillable = ['message_id', 'user_id', 'status', 'updated_at'];

    public function message()
    {
        return $this->belongsTo(Messages::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

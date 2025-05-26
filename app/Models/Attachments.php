<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    public $timestamps = false;
    protected $fillable = ['message_id', 'file_url', 'file_type', 'file_size', 'thumbnail_url'];

    public function message()
    {
        return $this->belongsTo(Messages::class);
    }
}

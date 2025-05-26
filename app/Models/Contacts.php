<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id', 'contact_id', 'nickname', 'blocked', 'created_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->belongsTo(User::class, 'contact_id');
    }
}

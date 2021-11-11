<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'receiver_id',
        'sender_id',
        'content',
        'file',
    ];

    protected $casts = [
        'file' => 'boolean'
    ];

    public function files()
    {
        return $this->morphOne(File::class, 'fileable');
    }
}

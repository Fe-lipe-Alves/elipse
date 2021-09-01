<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
    public $timestamps = false;
    protected $fillable = [
        'action',
        'user_id',
        'model_type',
        'model_id',
        'before',
        'after',
        'created_at'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'before' => 'array',
        'after' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function model()
    {
        return $this->morphTo();
    }
}

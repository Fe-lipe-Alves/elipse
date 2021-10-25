<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseWork extends Model
{
    protected $fillable = [
        'student_id',
        'work_id',
        'grade',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}

<?php

namespace App\Models;

use App\Repositories\Contracts\StudentsClassInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'title',
        'description',
        'deadline',
        'grade',
        'lesson_id',
    ];

    protected $casts = [
        'deadline' => 'datetime:Y-m-d H:i'
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function studentsClass()
    {
        return $this->hasOneThrough(
            StudentsClass::class,
            Lesson::class,
            'id',
            'id',
            'lesson_id',
            'students_class_id'
        )->with('grade.gradeType');
    }

    public function getStudentsClassAttribute()
    {
        $studentsClass = $this->studentsClass()->first();

        $studentsClassRepository = app(StudentsClassInterface::class);
        return $studentsClassRepository->resolveNameGrade($studentsClass);
    }

    public function subject()
    {
        return $this->hasOneThrough(
            Subject::class,
            Lesson::class,
            'id',
            'id',
            'lesson_id',
            'subject_id'
        );
    }
}

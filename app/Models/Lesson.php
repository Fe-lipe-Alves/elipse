<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'teacher_id',
        'students_class_id'
    ];

    /**
     * Obtém a disciplina relacionada a esta aula
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Obtém o professor relacionado a esta aula
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    /**
     * Obtém a turma de alunos relacionadas a esta aula
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studentsClass()
    {
        return $this->belongsTo(StudentsClass::class);
    }

    /**
     * Obtém a lista de horários da aula
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules()
    {
        return $this->hasMany(ClassSchedule::class);
    }
}

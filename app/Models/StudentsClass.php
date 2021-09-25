<?php

namespace App\Models;

use App\Support\Traits\LoggerTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentsClass extends Model
{
    use HasFactory;
    use LoggerTrait;
    use SoftDeletes;

    protected $fillable = [
        'grade_id',
        'name',
        'active',
    ];

    public function getDescriptionAttribute($value)
    {
        $gradeType = $this->grade()->with('gradeType')->first()->gradeType->description;
        return $this->grade_id . 'ª ' . $this->name . ' - '. $gradeType ;
    }

    /**
     * Obtém a séria da classe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    /**
     * Obtém a lista de alunos da classe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'student_students_class',
            'students_class_id',
            'student_id',
        );
    }
}

<?php

namespace App\Models;

use App\Support\Traits\LoggerTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use HasFactory;
    use LoggerTrait;
    use SoftDeletes;

    protected $fillable = [
        'grade_type_id',
        'year',
    ];

    /**
     * Obtém o tipo de ensino da séria
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gradeType()
    {
        return $this->belongsTo(GradeType::class);
    }

    /**
     * Obtém as classes da série
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentsClasses()
    {
        return $this->hasMany(StudentsClass::class);
    }
}

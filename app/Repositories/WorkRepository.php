<?php

namespace App\Repositories;

use App\Models\Work;
use App\Repositories\Contracts\WorkRepositoryInterface;
use App\Support\Traits\HasModel;

class WorkRepository implements WorkRepositoryInterface
{
    use HasModel;

    private $modelClass = Work::class;

    public function getWorksByTeacher($teacherId)
    {
        $works = Work::query()->get();

        return $works;
    }

    public function getWorks()
    {
        return Work::all();
    }
}

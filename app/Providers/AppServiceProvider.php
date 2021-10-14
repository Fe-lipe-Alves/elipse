<?php

namespace App\Providers;

use App\Repositories\Contracts\FileRepositoryInterface;
use App\Repositories\Contracts\GradeRepositoryInterface;
use App\Repositories\Contracts\GradeTypeRepositoryInterface;
use App\Repositories\Contracts\LessonRepositoryInterface;
use App\Repositories\Contracts\StudentsClassInterface;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\WorkRepositoryInterface;
use App\Repositories\FileRepository;
use App\Repositories\GradeRepository;
use App\Repositories\GradeTypeRepository;
use App\Repositories\LessonRepository;
use App\Repositories\StudentsClassRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(StudentsClassInterface::class, StudentsClassRepository::class);
        $this->app->bind(GradeRepositoryInterface::class, GradeRepository::class);
        $this->app->bind(GradeTypeRepositoryInterface::class, GradeTypeRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(WorkRepositoryInterface::class, WorkRepository::class);
        $this->app->bind(SubjectRepositoryInterface::class, SubjectRepository::class);
        $this->app->bind(LessonRepositoryInterface::class, LessonRepository::class);
        $this->app->bind(FileRepositoryInterface::class, FileRepository::class);
    }
}

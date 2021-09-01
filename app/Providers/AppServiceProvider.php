<?php

namespace App\Providers;

use App\Repositories\Contracts\GradeRepositoryInterface;
use App\Repositories\Contracts\GradeTypeRepositoryInterface;
use App\Repositories\Contracts\StudentsClassInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\GradeRepository;
use App\Repositories\GradeTypeRepository;
use App\Repositories\StudentsClassRepository;
use App\Repositories\UserRepository;
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
    }
}

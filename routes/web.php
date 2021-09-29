<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\StudentsClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resourceVerbs([
    'create' => 'criar',
    'edit'   => 'editar',
]);

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');


Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::resource('usuarios', UserController::class)
        ->parameters(['usuarios' => 'user'])
        ->names('users');

    Route::resource('turmas', StudentsClassController::class)
        ->parameters(['turmas' => 'studentsClass'])
        ->names('students_class');

    Route::get('turmas/{studentsClass}/professores', [StudentsClassController::class, 'teachers'])
        ->name('students_class.teachers');

    Route::resource('trabalhos', WorkController::class)
        ->parameters(['trabalhos' => 'work'])
        ->names('works');

    Route::resource('disciplinas', SubjectController::class)
        ->parameters(['disciplinas' => 'subject'])
        ->names('subjects');

    Route::resource('aulas', LessonController::class)
        ->parameters(['aulas' => 'lesson'])
        ->names('lessons');

});
//Route::get('checkName', [StudentsClassController::class, 'checkName'])->name('checkName');

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MessageController;
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
Route::view('resetar_senha', 'auth.reset_password_email')->name('reset_password.email');
Route::get('resetar_senha/token', [AuthController::class, 'resetPasswordReturn'])->name('reset_password.return');
//Route::post('resetar_senha', [AuthController::class, 'resetPassword'])->name('reset_password.save');
Route::post('resetar_senha', [AuthController::class, 'resetPasswordSendEmail'])->name('reset_password.send_email');
Route::post('resetar_senha/save', [AuthController::class, 'resetPasswordSave'])->name('reset_password.save');


Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

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

    Route::post('trabalhos/{work}/resposta', [WorkController::class, 'response'])
        ->name('works.response');

    Route::resource('disciplinas', SubjectController::class)
        ->parameters(['disciplinas' => 'subject'])
        ->names('subjects');

    Route::resource('aulas', LessonController::class)
        ->parameters(['aulas' => 'lesson'])
        ->names('lessons');

    Route::post('aulas/consultar-horario', [LessonController::class, 'consultSchedule'])
        ->name('lessons.consult_schedule');

    Route::get('mensagens', [MessageController::class, 'index'])
        ->name('messages.index');

    Route::get('mensagens/nova',[MessageController::class, 'new'])
        ->name('messages.new');

    Route::post('mensagens/enviar', [MessageController::class, 'send'])
        ->name('messages.send');

    Route::get('mensagens/historico/{receiver_id}/{offset?}',[MessageController::class, 'history'])
        ->name('messages.history');

});

Route::view('ajuda', 'help.index')->name('help');
Route::view('ajuda/usuarios', 'help.users')->name('help.users');
Route::view('ajuda/disciplinas', 'help.subjects')->name('help.subjects');
Route::view('ajuda/aulas', 'help.lessons')->name('help.lessons');
Route::view('ajuda/turmas', 'help.students_class')->name('help.students_class');
Route::view('ajuda/trabalhos', 'help.works')->name('help.works');

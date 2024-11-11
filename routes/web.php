<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
Route::get('/', function () {
    return view('Home');
});
    Route::get('/import', [ImportController::class, 'showForm'])->name('import');
Route::post('/import/students', [ImportController::class, 'importStudents'])->name('import.students');
Route::post('/import/subjects', [ImportController::class, 'importStudentSubjects'])->name('import.subjects');

//students
Route::get('/students', [App\Http\Controllers\StudentController::class, 'index'])->name('students');
Route::get('/students.create', [App\Http\Controllers\StudentController::class, 'create'])->name('students.create');
Route::post('/students.store', [App\Http\Controllers\StudentController::class, 'store'])->name('students.store');
Route::get('/students_edit/{id}', [App\Http\Controllers\StudentController::class, 'edit'])->name('students_edit');
Route::post('/students_update/{id}', [App\Http\Controllers\StudentController::class, 'update'])->name('students_update');
Route::delete('/students.destroy/{id}', [App\Http\Controllers\StudentController::class, 'destroy'])->name('students.destroy');
Route::get('/student-card/{studentId}', [StudentController::class, 'showStudentCard'])->name('student.card');
Route::get('/students/image/{id}', [App\Http\Controllers\StudentController::class, 'image'])->name('students.image');

Route::post('/students/image/update/{id}', [App\Http\Controllers\StudentController::class, 'updateImage'])->name('students.image.update');

//studentSubjects
Route::get('/subjects', [App\Http\Controllers\SubjectController::class, 'index'])->name('subjects');
Route::get('/subjects/qr-code', [App\Http\Controllers\StudentController::class, 'getStudents'])->name('qr-code');
Route::post('/subjects.store', [App\Http\Controllers\SubjectController::class, 'store'])->name('subjects.store');
Route::get('/subjects.edit/{id}', [App\Http\Controllers\SubjectController::class, 'edit'])->name('subjects.edit');
Route::post('/subjects/{studentSubject}/update', [SubjectController::class, 'update'])->name('subjects.update');
Route::delete('subjects/delete-all', [SubjectController::class, 'deleteAll'])->name('subjects.deleteAll');
Route::delete('subjects/{id}', [SubjectController::class, 'destroy'])->name('subjects_destroy');


//exams
Route::get('/exams', [App\Http\Controllers\ExamController::class, 'index'])->name('exams');
Route::get('/Create', [App\Http\Controllers\ExamController::class, 'create'])->name('exams.create');
Route::post('/store', [App\Http\Controllers\ExamController::class, 'store'])->name('exams.store');
Route::get('/edit/{id}', [App\Http\Controllers\ExamController::class, 'edit'])->name('exams.edit');
Route::post('/update/{id}', [App\Http\Controllers\ExamController::class, 'update'])->name('exams.update');
Route::delete('/delete/{id}', [App\Http\Controllers\ExamController::class, 'destroy'])->name('exams.delete');
Route::delete('/exams/delete-all', [ExamController::class, 'deleteAll'])->name('exams.deleteAll');

Route::post('/check-exam', [StudentController::class, 'checkExam']);


Route::get('/users', [UserController::class, 'index'])->name('users');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit', [UserController::class, 'edit1'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

});

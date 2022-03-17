<?php

use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentExamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect('home');
})->middleware('auth');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


//administrator
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    //users
    Route::group(['prefix' => 'users'], function () {
        Route::get('index', [UserController::class, 'index'])->name('users.index');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::get('destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::post('store', [UserController::class, 'store'])->name('users.store');
        Route::post('update', [UserController::class, 'update'])->name('users.update');
    });

    //colleges
    Route::group(['prefix' => 'colleges'], function () {
        Route::get('index', [CollegeController::class, 'index'])->name('colleges.index');
        Route::get('getColleges', [CollegeController::class, 'create'])->name('colleges.get');
        Route::get('edit/{id}', [CollegeController::class, 'edit'])->name('colleges.edit');
        Route::get('destroy/{id}', [CollegeController::class, 'destroy'])->name('colleges.destroy');

        Route::post('store', [CollegeController::class, 'store'])->name('colleges.store');
        Route::post('update', [CollegeController::class, 'update'])->name('colleges.update');
    });


    //courses
    Route::group(['prefix' => 'courses'], function () {
        Route::get('index', [CourseController::class, 'index'])->name('courses.index');
        Route::get('getCourse', [CourseController::class, 'create'])->name('courses.get');
        Route::get('edit/{id}', [CourseController::class, 'edit'])->name('courses.edit');
        Route::get('destroy/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');

        Route::post('store', [CourseController::class, 'store'])->name('courses.store');
        Route::post('update', [CourseController::class, 'update'])->name('courses.update');
    });


    //students
    Route::group(['prefix' => 'students'], function () {
        Route::get('index', [StudentController::class, 'index'])->name('students.index');
        Route::get('getStudents', [StudentController::class, 'create'])->name('students.get');
        Route::get('edit/{id}', [StudentController::class, 'edit'])->name('students.edit');
        Route::get('destroy/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

        Route::post('store', [StudentController::class, 'store'])->name('students.store');
        Route::post('update', [StudentController::class, 'update'])->name('students.update');
    });

    //halls
    Route::group(['prefix' => 'halls'], function () {
        Route::get('index', [HallController::class, 'index'])->name('halls.index');
        Route::get('getHalls', [HallController::class, 'create'])->name('halls.get');
        Route::get('edit/{id}', [HallController::class, 'edit'])->name('halls.edit');
        Route::get('destroy/{id}', [HallController::class, 'destroy'])->name('halls.destroy');

        Route::post('store', [HallController::class, 'store'])->name('halls.store');
        Route::post('update', [HallController::class, 'update'])->name('halls.update');
    });
});

//teacher
Route::group(['prefix' => 'teacher', 'middleware' => ['auth']], function () {
    //exams
    Route::group(['prefix' => 'exams'], function () {
        Route::get('index', [ExamController::class, 'index'])->name('exams.index');
        Route::get('getExams', [ExamController::class, 'create'])->name('exams.get');
        Route::get('edit/{id}', [ExamController::class, 'edit'])->name('exams.edit');
        Route::get('destroy/{id}', [ExamController::class, 'destroy'])->name('exams.destroy');
        Route::get('inputExam/{id}', [ExamController::class, 'inputExam'])->name('exams.inputExam');


        Route::post('store', [ExamController::class, 'store'])->name('exams.store');
        Route::post('update', [ExamController::class, 'update'])->name('exams.update');
    });

    //studentExam
    Route::group(['prefix' => 'studentExam'], function () {
        Route::get('index', [StudentExamController::class, 'index'])->name('studentExam.index');
        Route::get('getStudentExam', [StudentExamController::class, 'create'])->name('studentExam.get');
        Route::get('edit/{id}', [StudentExamController::class, 'edit'])->name('studentExam.edit');
        Route::get('destroy/{id}', [StudentExamController::class, 'destroy'])->name('studentExam.destroy');

        Route::post('store', [StudentExamController::class, 'store'])->name('studentExam.store');
        Route::post('update', [StudentExamController::class, 'update'])->name('studentExam.update');
        Route::post('updateAtt', [StudentExamController::class, 'updateAtt'])->name('studentExam.updateAtt');
    });
});


//administrator and teacher
Route::group(['prefix' => 'profile', 'middleware' => ['auth']], function () {
    Route::get('index', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('PlInfoUpdate', [ProfileController::class, 'PersonalInformationUpdate'])->name('PersonalInformationUpdate');
    Route::post('PasswordUpdate', [ProfileController::class, 'PasswordUpdate'])->name('PasswordUpdate');
    Route::post('ProfileInfoUpdate', [ProfileController::class, 'ProfileInfoUpdate'])->name('ProfileInfoUpdate');
});

<?php

use Illuminate\Support\Facades\Route;

// Dashboard
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\CurriculumController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\StudentResourcesController;
use App\Http\Controllers\Admin\LibraryResourceController;
use App\Http\Controllers\Admin\OnlineLearningController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ClubsController;
use App\Http\Controllers\Admin\SportsController;
use App\Http\Controllers\Admin\AcademicCalendarController;
use App\Http\Controllers\Admin\VirtualTourController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\BannerSlideController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\AdmissionController;
use App\Http\Controllers\Admin\StudentHandbookController;
use App\Http\Controllers\Auth\AuthController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::controller(AuthController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'web'])->group(function () {
    Route::middleware(['check_role'])->prefix('admin')->as('admin.')->group(function () {
        Route::get('dashboard', DashboardController::class)->name('dashboard');
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('curricula', CurriculumController::class);
        Route::resource('student-resources', StudentResourcesController::class);
        Route::resource('library-resources', LibraryResourceController::class);
        Route::resource('online-learning', OnlineLearningController::class);
        Route::resource('exams', ExamController::class);
        Route::resource('events', EventController::class);
        Route::resource('news', NewsController::class);
        Route::resource('clubs', ClubsController::class);
        Route::resource('sports', SportsController::class);
        Route::resource('academic-calendar', AcademicCalendarController::class);
        Route::resource('virtual-tour', VirtualTourController::class);
        Route::resource('about', AboutController::class);
        Route::resource('banner-slide', BannerSlideController::class);
        Route::resource('testimonial', TestimonialController::class);
        Route::resource('admission', AdmissionController::class);
        Route::resource('student-handbook', StudentHandbookController::class);
         

        Route::prefix('enrollments')->as('enrollments.')->group(function () {
            Route::get('/', [EnrollmentController::class, 'index'])->name('index');
            Route::get('/create', [EnrollmentController::class, 'create'])->name('create')->middleware('checkCurriculum');
            Route::get('/{enrollment}', [EnrollmentController::class, 'show'])->name('show');
            Route::post('/', [EnrollmentController::class, 'store'])->name('store');
            Route::get('/{enrollment}/edit', [EnrollmentController::class, 'edit'])->name('edit')->middleware('checkCurriculum');
            Route::put('/{enrollment}', [EnrollmentController::class, 'update'])->name('update');
            Route::delete('/{enrollment}', [EnrollmentController::class, 'destroy'])->name('destroy');
            Route::post('/validate-curriculum', [EnrollmentController::class, 'validateCurriculum'])->name('validate-curriculum');
            Route::post('/validate-edit-curriculum', [EnrollmentController::class, 'validateEditCurriculum'])->name('validate-edit-curriculum');
        });
        // Route::resource('enrollments', EnrollmentController::class);
    });
});




// Route::get('/', function () {
//     return view('admin.dashboard.index');
// });
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Enums\TokenAbility;


use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\CurriculumController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\StudentResourcesController;
use App\Http\Controllers\Api\LibraryResourceController;
use App\Http\Controllers\Api\OnlineLearningController;
use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\ClubsController;
use App\Http\Controllers\Api\SportsController;
use App\Http\Controllers\Api\AcademicCalendarController;
use App\Http\Controllers\Api\VirtualTourController;
use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\BannerSlideController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\AdmissionController;
use App\Http\Controllers\Api\StudentHandbookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function(){
    // Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware(['cors'])->group( function () {
    Route::resource('curricula', CurriculumController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('about', AboutController::class);
    Route::resource('banner-slide', BannerSlideController::class);
    Route::resource('virtual-tour', VirtualTourController::class);
    Route::resource('testimonial', TestimonialController::class);
    Route::resource('admission', AdmissionController::class);
    Route::resource('student-handbook', StudentHandbookController::class);
});        

Route::middleware([
    'cors', 
    // 'auth:sanctum', 
    // 'ability:' . TokenAbility::ISSUE_ACCESS_TOKEN->value
])->group(function () {
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);
});

Route::middleware([
    'auth:sanctum', 
    'cors', 
    // 'ability:' . TokenAbility::ACCESS_API->value
])->group( function () {
    Route::resource('events', EventsController::class);
    Route::resource('news', NewsController::class);
    Route::resource('enrollment', EnrollmentController::class);
    Route::resource('clubs', ClubsController::class);
    Route::resource('sports', SportsController::class);
    Route::resource('student-resources', StudentResourcesController::class);
    Route::resource('library-resources', LibraryResourceController::class);
    Route::resource('online-learning', OnlineLearningController::class);
    Route::resource('exams', ExamController::class);
    Route::resource('academic-calendar', AcademicCalendarController::class);
    
    
    Route::get('getEnrollmentByStudent/{studentId}', [EnrollmentController::class, 'getEnrollmentByStudent']);

    Route::post('joinClubMember', [ClubsController::class, 'joinClubMember']);
    Route::post('joinSportMember', [SportsController::class, 'joinSportMember']);

    Route::post('logout', [AuthController::class, 'logout']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

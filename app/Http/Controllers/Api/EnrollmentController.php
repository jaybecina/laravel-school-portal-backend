<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Enrollment;
use App\Models\Curriculum;
use App\Models\Course;
use App\Models\EnrollmentPivot;
use Validator;
use App\Http\Resources\EnrollmentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Query\Builder;


class EnrollmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        // Fetch enrollments
        $enrollments = Enrollment::all();

        $courses = Course::all();

        
    
        return $this->sendResponse(EnrollmentResource::collection($enrollments), 'Enrollments retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        //
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        // $goals = Goal::with('moments', 'moments.contact')
        // ->where('authId', Auth::id())
        // ->where('hidden', 'false')
        // ->get();

        $enrollment = Enrollment::find($id);

        // $curriculum = $enrollment->curricula->first();

        // $course = $curriculum->courses->where('enrollment_id', $enrollment->id)->where('curriculum_id', $curriculum->id)->first();

        // $enrollment_data = [
        //     'enrollment' => $enrollment,
        //     'curriculum' => $curriculum->distinct(),
        //     'courses' => $course
        // ];
  
        if (is_null($enrollment)) {
            return $this->sendError('Enrollment not found.');
        }
   
        return $this->sendResponse(new EnrollmentResource($enrollment), 'Enrollment retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEnrollmentByStudent($studentId): JsonResponse
    {
        $enrollments = Enrollment::where('student_id', $studentId)
        ->orderBy('created_at', 'desc')
        ->get();
   
        return $this->sendResponse(EnrollmentResource::collection($enrollments), 'Enrollments retrieved successfully.');
        
        // return response()->json($enrollment);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enrollment $enrollment): JsonResponse
    {
        //
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enrollment $enrollment): JsonResponse
    {
        //
    }
}

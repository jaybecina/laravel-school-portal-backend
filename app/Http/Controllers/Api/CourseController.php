<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Course;
use Validator;
use App\Http\Resources\CourseResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class CourseController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        $keyword = $request->input('keyword');
        $field = $request->input('field');

        if ($keyword !== null) {
            $course = Course::when($field === 'course_code', function ($query) use ($keyword) {
                return $query->where('course_code', 'like', '%' . $keyword . '%');
            })->when($field === 'title', function ($query) use ($keyword) {
                return $query->where('title', 'like', '%' . $keyword . '%');
            })->when($field === 'desc', function ($query) use ($keyword) {
                return $query->where('desc', 'like', '%' . $keyword . '%');
            })->when($field === 'credits', function ($query) use ($keyword) {
                return $query->where('credits', 'like', '%' . $keyword . '%');
            })->when($field === 'all', function ($query) use ($keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->where('course_code', 'like', '%' . $keyword . '%')
                        ->orWhere('title', 'like', '%' . $keyword . '%')
                        ->orWhere('credits', 'like', '%' . $keyword . '%');
                });
            })->get();
        } else {
            $course = Course::latest()->paginate(5);
        }
    
        return $this->sendResponse(CourseResource::collection($course), 'Courses retrieved successfully.');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $course = Course::find($id);
  
        if (is_null($course)) {
            return $this->sendError('Course not found.');
        }
   
        return $this->sendResponse(new CourseResource($course), 'Course retrieved successfully.');
    }
}

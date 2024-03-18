<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Subject;
use Validator;
use App\Http\Resources\SubjectResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class SubjectController extends BaseController
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
            $subject = Subject::when($field === 'subject_code', function ($query) use ($keyword) {
                return $query->where('subject_code', 'like', '%' . $keyword . '%');
            })->when($field === 'name', function ($query) use ($keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })->when($field === 'detail', function ($query) use ($keyword) {
                return $query->where('detail', 'like', '%' . $keyword . '%');
            })->when($field === 'day', function ($query) use ($keyword) {
                return $query->where('day', 'like', '%' . $keyword . '%');
            })->when($field === 'start_time', function ($query) use ($keyword) {
                return $query->where('start_time', 'like', '%' . $keyword . '%');
            })->when($field === 'room_no', function ($query) use ($keyword) {
                return $query->where('room_no', 'like', '%' . $keyword . '%');
            })->when($field === 'all', function ($query) use ($keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->where('subject_code', 'like', '%' . $keyword . '%')
                        ->orWhere('name', 'like', '%' . $keyword . '%')
                        ->orWhere('detail', 'like', '%' . $keyword . '%')
                        ->orWhere('day', 'like', '%' . $keyword . '%')
                        ->orWhere('start_time', 'like', '%' . $keyword . '%')
                        ->orWhere('room_no', 'like', '%' . $keyword . '%');
                });
            })->get();
        } else {
            $subject = Subject::latest()->paginate(5);
        }
    
        return $this->sendResponse(SubjectResource::collection($subject), 'Subjects retrieved successfully.');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $subject = Subject::find($id);
  
        if (is_null($subject)) {
            return $this->sendError('Subject not found.');
        }
   
        return $this->sendResponse(new SubjectResource($subject), 'Subject retrieved successfully.');
    }
}

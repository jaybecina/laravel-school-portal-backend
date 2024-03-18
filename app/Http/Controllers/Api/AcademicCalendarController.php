<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\AcademicCalendar;
use Validator;
use App\Http\Resources\AcademicCalendarResource;
use Illuminate\Http\JsonResponse;


class AcademicCalendarController extends BaseController
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
            $academicCalendars = AcademicCalendar::when($field === 'title', function ($query) use ($keyword) {
                return $query->where('title', 'like', '%' . $keyword . '%');
            })->when($field === 'desc', function ($query) use ($keyword) {
                return $query->where('desc', 'like', '%' . $keyword . '%');
            })->when($field === 'start_date', function ($query) use ($keyword) {
                return $query->where('start_date', 'like', '%' . $keyword . '%');
            })->when($field === 'all', function ($query) use ($keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->where('title', 'like', '%' . $keyword . '%')
                        ->orWhere('desc', 'like', '%' . $keyword . '%')
                        ->orWhere('start_date', 'like', '%' . $keyword . '%');
                });
            })->get();
        } else {
            $academicCalendars = AcademicCalendar::all();
        }
    
        return $this->sendResponse(AcademicCalendarResource::collection($academicCalendars), 'Academic Calendar Data retrieved successfully.');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $academicCalendar = AcademicCalendar::find($id);
  
        if (is_null($academicCalendar)) {
            return $this->sendError('Academic Calendar Data not found.');
        }
   
        return $this->sendResponse(new AcademicCalendarResource($academicCalendar), 'Academic Calendar Data retrieved successfully.');
    }
}

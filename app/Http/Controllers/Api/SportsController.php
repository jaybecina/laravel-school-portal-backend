<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Sport;
use Validator;
use App\Http\Resources\SportResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;


class SportsController extends BaseController
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
            $sports = Sport::when($field === 'name', function ($query) use ($keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })->when($field === 'details', function ($query) use ($keyword) {
                return $query->where('details', 'like', '%' . $keyword . '%');
            })->when($field === 'all', function ($query) use ($keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('details', 'like', '%' . $keyword . '%');
                });
            })->get();
        } else {
            $sports = Sport::all();
        }
    
        return $this->sendResponse(SportResource::collection($sports), 'Sports retrieved successfully.');
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

    public function joinSportMember(Request $request): JsonResponse
    {
        $sport = Sport::find($request->id);
        $sport->students()->attach([$request->student_id]);

        return $this->sendResponse(New SportResource($sport), 'Sport member has joined successfully.');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $sport = Sport::find($id);
  
        if (is_null($sport)) {
            return $this->sendError('Sport not found.');
        }
   
        return $this->sendResponse(new SportResource($sport), 'Sport retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sport $sport): JsonResponse
    {
        //
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sport $sport): JsonResponse
    {
        //
    }
}

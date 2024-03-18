<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Club;
use Validator;
use App\Http\Resources\ClubResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;


class ClubsController extends BaseController
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
            $clubs = Club::when($field === 'name', function ($query) use ($keyword) {
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
            $clubs = Club::all();
        }
    
        return $this->sendResponse(ClubResource::collection($clubs), 'Clubs retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        // $input = $request->all();
   
        // $validator = Validator::make($input, [
        //     'name' => 'required|unique:clubs',
        //     'details' => 'required',
        //     'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        // ]);
   
        // if($validator->fails()){
        //     return $this->sendError('Validation Error.', $validator->errors());       
        // }
   
        // // $club = Club::create($input);

        // $image_path = $request->file('image')->store('clubs', 'public');

        // $club = new Club; 
        // $club->name = $input['name'];
        // $club->details = $input['details'];
        // $club->image = $image_path;
        // $club->start_date = $input['start_date'];
        // $club->end_date = $input['end_date'];
        // $club->speaker_name = $input['speaker_name'];
        // $club->is_active = 1;
        // $club->save();
   
        // return $this->sendResponse(new ClubResource($club), 'Club created successfully.');
    } 

    public function joinClubMember(Request $request): JsonResponse
    {
        $club = Club::find($request->id);
        $club->students()->attach([$request->student_id]);

        return $this->sendResponse(New ClubResource($club), 'Club member has joined successfully.');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $club = Club::find($id);
  
        if (is_null($club)) {
            return $this->sendError('Club not found.');
        }
   
        return $this->sendResponse(new ClubResource($club), 'Club retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club): JsonResponse
    {
        // $input = $request->all();
   
        // $validator = Validator::make($input, [
        //     'name' => 'required',
        //     'details' => 'required',
        //     'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        // ]);
   
        // if($validator->fails()){
        //     return $this->sendError('Validation Error.', $validator->errors());       
        // }
   
        // $club->name = $input['name'];
        // $club->details = $input['details'];
        // $club->start_date = $input['start_date'];
        // $club->end_date = $input['end_date'];
        // $club->speaker_name = $input['speaker_name'];
        // $club->save();
   
        // return $this->sendResponse(new ClubResource($club), 'Club updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club): JsonResponse
    {
        //
    }
}

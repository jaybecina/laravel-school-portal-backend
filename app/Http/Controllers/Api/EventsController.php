<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Event;
use Validator;
use App\Http\Resources\EventResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;


class EventsController extends BaseController
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
            $events = Event::when($field === 'name', function ($query) use ($keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })->when($field === 'details', function ($query) use ($keyword) {
                return $query->where('details', 'like', '%' . $keyword . '%');
            })->when($field === 'start_date', function ($query) use ($keyword) {
                return $query->where('start_date', 'like', '%' . $keyword . '%');
            })->when($field === 'speaker_name', function ($query) use ($keyword) {
                return $query->where('speaker_name', 'like', '%' . $keyword . '%');
            })->when($field === 'all', function ($query) use ($keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('details', 'like', '%' . $keyword . '%')
                        ->orWhere('start_date', 'like', '%' . $keyword . '%')
                        ->orWhere('speaker_name', 'like', '%' . $keyword . '%');
                });
            })->get();
        } else {
            $events = Event::all();
        }
    
        return $this->sendResponse(EventResource::collection($events), 'Events retrieved successfully.');
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
        //     'name' => 'required|unique:events',
        //     'details' => 'required',
        //     'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        //     'start_date' => 'required',
        //     'end_date' => 'required',
        //     'speaker_name' => 'required',
        // ]);
   
        // if($validator->fails()){
        //     return $this->sendError('Validation Error.', $validator->errors());       
        // }
   
        // // $event = Event::create($input);

        // $image_path = $request->file('image')->store('events', 'public');

        // $event = new Event; 
        // $event->name = $input['name'];
        // $event->details = $input['details'];
        // $event->image = $image_path;
        // $event->start_date = $input['start_date'];
        // $event->end_date = $input['end_date'];
        // $event->speaker_name = $input['speaker_name'];
        // $event->is_active = 1;
        // $event->save();
   
        // return $this->sendResponse(new EventResource($event), 'Event created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $event = Event::find($id);
  
        if (is_null($event)) {
            return $this->sendError('Event not found.');
        }
   
        return $this->sendResponse(new EventResource($event), 'Event retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event): JsonResponse
    {
        // $input = $request->all();
   
        // $validator = Validator::make($input, [
        //     'name' => 'required',
        //     'details' => 'required',
        //     'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        //     'start_date' => 'required',
        //     'end_date' => 'required',
        //     'speaker_name' => 'required',
        // ]);
   
        // if($validator->fails()){
        //     return $this->sendError('Validation Error.', $validator->errors());       
        // }
   
        // $event->name = $input['name'];
        // $event->details = $input['details'];
        // $event->start_date = $input['start_date'];
        // $event->end_date = $input['end_date'];
        // $event->speaker_name = $input['speaker_name'];
        // $event->save();
   
        // return $this->sendResponse(new EventResource($event), 'Event updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event): JsonResponse
    {
        // $event->delete();
   
        // return $this->sendResponse([], 'Event deleted successfully.');
    }
}

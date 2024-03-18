<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Testimonial;
use Validator;
use App\Http\Resources\TestimonialResource;
use Illuminate\Http\JsonResponse;


class TestimonialController extends BaseController
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
            $all_testimonial = Testimonial::when($field === 'title', function ($query) use ($keyword) {
                return $query->where('title', 'like', '%' . $keyword . '%');
            })->when($field === 'body', function ($query) use ($keyword) {
                return $query->where('body', 'like', '%' . $keyword . '%');
            })->when($field === 'name', function ($query) use ($keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })->when($field === 'all', function ($query) use ($keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->where('title', 'like', '%' . $keyword . '%')
                        ->orWhere('body', 'like', '%' . $keyword . '%')
                        ->orWhere('name', 'like', '%' . $keyword . '%');
                });
            })->get();
        } else {
            $all_testimonial = Testimonial::all();
        }
    
        return $this->sendResponse(TestimonialResource::collection($all_testimonial), 'All Testimonials retrieved successfully.');
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
        $testimonial = Testimonial::find($id);
  
        if (is_null($testimonial)) {
            return $this->sendError('Testimonial not found.');
        }
   
        return $this->sendResponse(new TestimonialResource($testimonial), 'A Testimonial retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimonial $testimonial): JsonResponse
    {
        //
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial): JsonResponse
    {
        //
    }
}

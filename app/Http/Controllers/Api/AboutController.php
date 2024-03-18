<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\About;
use Validator;
use App\Http\Resources\AboutResource;
use Illuminate\Http\JsonResponse;


class AboutController extends BaseController
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
            $abouts = About::when($field === 'title', function ($query) use ($keyword) {
                return $query->where('title', 'like', '%' . $keyword . '%');
            })->when($field === 'body', function ($query) use ($keyword) {
                return $query->where('body', 'like', '%' . $keyword . '%');
            })->when($field === 'all', function ($query) use ($keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->where('title', 'like', '%' . $keyword . '%')
                        ->orWhere('body', 'like', '%' . $keyword . '%');
                });
            })->get();
        } else {
            $abouts = About::all();
        }
    
        return $this->sendResponse(AboutResource::collection($abouts), 'About retrieved successfully.');
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
        $about = About::find($id);
  
        if (is_null($about)) {
            return $this->sendError('About not found.');
        }
   
        return $this->sendResponse(new AboutResource($about), 'An About retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, About $about): JsonResponse
    {
        //
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(About $about): JsonResponse
    {
        //
    }
}

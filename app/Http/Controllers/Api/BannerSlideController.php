<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\BannerSlide;
use Validator;
use App\Http\Resources\BannerSlideResource;
use Illuminate\Http\JsonResponse;


class BannerSlideController extends BaseController
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
            $bannerSlides = BannerSlide::when($field === 'title', function ($query) use ($keyword) {
                return $query->where('title', 'like', '%' . $keyword . '%');
            })->when($field === 'body', function ($query) use ($keyword) {
                return $query->where('body', 'like', '%' . $keyword . '%');
            })->when($field === 'link', function ($query) use ($keyword) {
                return $query->where('link', 'like', '%' . $keyword . '%');
            })->when($field === 'all', function ($query) use ($keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->where('title', 'like', '%' . $keyword . '%')
                        ->orWhere('body', 'like', '%' . $keyword . '%')
                        ->orWhere('link', 'like', '%' . $keyword . '%');
                });
            })->get();
        } else {
            $bannerSlides = BannerSlide::all();
        }
    
        return $this->sendResponse(BannerSlideResource::collection($bannerSlides), 'All Banner Slide retrieved successfully.');
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
        $bannerSlide = BannerSlide::find($id);
  
        if (is_null($bannerSlide)) {
            return $this->sendError('Banner Slide not found.');
        }
   
        return $this->sendResponse(new BannerSlideResource($bannerSlide), 'A Banner Slide retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BannerSlide $news): JsonResponse
    {
        //
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BannerSlide $news): JsonResponse
    {
        //
    }
}

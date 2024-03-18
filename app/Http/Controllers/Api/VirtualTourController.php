<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\VirtualTour;
use Validator;
use App\Http\Resources\VirtualTourResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Query\Builder;

class VirtualTourController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $field = $request->input('field');

        if ($keyword !== null) {
            $virtualTour = VirtualTour::when($field === 'title', function ($query) use ($keyword) {
                return $query->where('title', 'like', '%' . $keyword . '%');
            })->when($field === 'desc', function ($query) use ($keyword) {
                return $query->where('desc', 'like', '%' . $keyword . '%');
            })->when($field === 'videoId', function ($query) use ($keyword) {
                return $query->where('videoId', 'like', '%' . $keyword . '%');
            })->when($field === 'all', function ($query) use ($keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->where('title', 'like', '%' . $keyword . '%')
                        ->orWhere('desc', 'like', '%' . $keyword . '%')
                        ->orWhere('videoId', 'like', '%' . $keyword . '%');
                });
            })->get();
        } else {
            $virtualTour = VirtualTour::latest()->paginate(5);
        }
    
        return $this->sendResponse(VirtualTourResource::collection($virtualTour), 'Virtual Tour retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $virtualTour = VirtualTour::find($id);
  
        if (is_null($virtualTour)) {
            return $this->sendError('Virtual Tour not found.');
        }
   
        return $this->sendResponse(new VirtualTourResource($virtualTour), 'A Virtual Tour retrieved successfully.');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\StudentResource;
use Validator;
use App\Http\Resources\StudentResourceResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Query\Builder;

class StudentResourcesController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $field = $request->input('field');

        if ($keyword !== null) {
            $studentResources = StudentResource::when($field === 'filename', function ($query) use ($keyword) {
                return $query->where('filename', 'like', '%' . $keyword . '%');
            })->when($field === 'content', function ($query) use ($keyword) {
                return $query->where('content', 'like', '%' . $keyword . '%');
            })->when($field === 'title', function ($query) use ($keyword) {
                return $query->where('title', 'like', '%' . $keyword . '%');
            })->when($field === 'desc', function ($query) use ($keyword) {
                return $query->where('desc', 'like', '%' . $keyword . '%');
            })->when($field === 'all', function ($query) use ($keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->where('filename', 'like', '%' . $keyword . '%')
                        ->orWhere('title', 'like', '%' . $keyword . '%')
                        ->orWhere('desc', 'like', '%' . $keyword . '%')
                        ->orWhere('content', 'like', '%' . $keyword . '%');
                });
            })->get();
        } else {
            $studentResources = StudentResource::latest()->paginate(5);
        }
    
        return $this->sendResponse(StudentResourceResource::collection($studentResources), 'Student Resources retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
        $studentResource = StudentResource::find($id);
  
        if (is_null($studentResource)) {
            return $this->sendError('Student Resource not found.');
        }
   
        return $this->sendResponse(new StudentResourceResource($studentResource), 'A Student Resource retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

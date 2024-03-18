<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Curriculum;
use Validator;
use App\Http\Resources\CurriculumResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class CurriculumController extends BaseController
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
            $curriculum = Curriculum::when($field === 'curriculum_code', function ($query) use ($keyword) {
                return $query->where('curriculum_code', 'like', '%' . $keyword . '%');
            })->when($field === 'name', function ($query) use ($keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })->when($field === 'desc', function ($query) use ($keyword) {
                return $query->where('desc', 'like', '%' . $keyword . '%');
            })->when($field === 'credits', function ($query) use ($keyword) {
                return $query->where('credits', 'like', '%' . $keyword . '%');
            })->when($field === 'all', function ($query) use ($keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->where('curriculum_code', 'like', '%' . $keyword . '%')
                        ->orWhere('name', 'like', '%' . $keyword . '%')
                        ->orWhere('desc', 'like', '%' . $keyword . '%')
                        ->orWhere('credits', 'like', '%' . $keyword . '%');
                });
            })->get();
        } else {
            $curriculum = Curriculum::latest()->paginate(5);
        }
    
        return $this->sendResponse(CurriculumResource::collection($curriculum), 'Curricula retrieved successfully.');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $curriculum = Curriculum::find($id);
  
        if (is_null($curriculum)) {
            return $this->sendError('Curriculum not found.');
        }
   
        return $this->sendResponse(new CurriculumResource($curriculum), 'Curriculum retrieved successfully.');
    }
}

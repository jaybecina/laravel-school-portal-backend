<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\Course;


class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $breadcrumbs = [];

    function __construct()
    {
        //  $this->middleware('permission:course-list|course-create|course-edit|course-delete', ['only' => ['index','show']]);
        //  $this->middleware('permission:course-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:course-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:course-delete', ['only' => ['destroy']]);

        // // $this->middleware(['role: Super Admin|Teacher']); 
        // $this->middleware(['role: Super Admin'], ['only' => ['index', 'show', 'create', 'store', 'update', 'destroy']]); 
        // $this->middleware(['role: Teacher'], ['only' => ['index', 'show', 'create', 'store']]); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $data = Course::latest()->paginate(5);
        return view('admin.courses.index',compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.courses.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        request()->validate([
            'course_code' => 'required|unique:courses',
            'title' => 'required|unique:courses',
            'desc' => 'required',
            'credits' => 'required',
        ]);
    
        Course::create($request->all());
    
        return redirect()->route('admin.courses.index')
                        ->with('success','Course created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course): View
    {
        return view('admin.courses.show',compact('course'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course): View
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        return view('admin.courses.edit',compact('course'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        request()->validate([
            'course_code' => 'required',
            'title' => 'required',
            'desc' => 'required',
            'credits' => 'required',
        ]);
    
        $course->update($request->all());
    
        return redirect()->route('admin.courses.index')
                        ->with('success','Course updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course): RedirectResponse
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        try{
            DB::beginTransaction();

            $course->delete();

            DB::commit();

            return redirect()->route('admin.courses.index')
                    ->with('success','Course deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.courses.index')
                            ->with('danger', $e->getMessage());
        }
    }
}

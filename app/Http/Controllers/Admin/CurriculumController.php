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
use App\Models\Curriculum;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Enrollment;


class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //  $this->middleware('permission:curriculum-list|curriculum-create|curriculum-edit|curriculum-delete', ['only' => ['index','show']]);
        //  $this->middleware('permission:curriculum-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:curriculum-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:curriculum-delete', ['only' => ['destroy']]);

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
        $data = Curriculum::with(['courses'])->latest()->paginate(5);

        return view('admin.curricula.index',compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        $courses = Course::orderBy('course_code', 'ASC')->get();

        $subjects = Subject::orderBy('subject_code', 'ASC')->get();

        return view('admin.curricula.create', compact('courses', 'subjects'));
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
            'curriculum_code' => 'required|unique:curricula',
            'name' => 'required|unique:curricula',
            'desc' => 'required',
            'credits' => 'required|numeric|min:1|max:50',
            'courses' => 'required',
            // 'subjects' => 'required',
        ]);

        $courses_checked_ids = $request->input('courses');

        // Check subject if empty
        foreach ($courses_checked_ids as $course_checked_id) {
            if(empty($request->input('subjects_' . $course_checked_id))) {
                return redirect()->route('admin.curricula.create')
                    ->with('danger','No subject selected with the course');
            }
        }
    
        // Curriculum::create($request->all());

        // dd(count($courses_checked_ids));
        // dd($request->all());

        $curriculum = new Curriculum;
        $curriculum->curriculum_code = $request->curriculum_code;
        $curriculum->name = $request->name;
        $curriculum->desc = $request->desc;
        $curriculum->credits = $request->credits;
        $curriculum->is_active = 1;

        if($curriculum->save()) {
            $courses = Course::whereIn('id', $courses_checked_ids)->get();

            foreach($courses as $course) {
                foreach($request->input('subjects_' . $course->id) as $subject_id) {
                    $curriculum->courses()->attach($course->id, ['subject_id' => $subject_id]);
                }
            }
        }
    
        return redirect()->route('admin.curricula.index')
                        ->with('success','Curriculum created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function show(Curriculum $curriculum): View
    {
        return view('admin.curricula.show',compact('curriculum'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function edit(Curriculum $curriculum): View
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        // dd($curriculum->courses->pluck('id'));

        $courses = Course::orderBy('course_code', 'ASC')->get();

        $subjects = Subject::orderBy('subject_code', 'ASC')->get();

        return view('admin.curricula.edit', compact('curriculum', 'courses', 'subjects'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curriculum $curriculum): RedirectResponse
    {
        request()->validate([
            'curriculum_code' => 'required',
            'name' => 'required',
            'desc' => 'required',
            'credits' => 'required|numeric|min:1|max:50',
            'courses' => 'required',
            'is_active' => 'required'
            // 'subjects' => 'required',
        ]);

        $courses_checked_ids = $request->input('courses');

        $saved_curr_ids = $request->input('saved_curr_ids'); // history data

        // Check subject if empty
        foreach ($courses_checked_ids as $course_checked_id) {
            if(empty($request->input('subjects_' . $course_checked_id))) {
                return redirect()->route('admin.curricula.edit')
                    ->with('danger','No subject selected with the course');
            }
        }
    
        // Curriculum::create($request->all());

        $curriculum = Curriculum::find($curriculum->id);
        $curriculum->curriculum_code = $request->curriculum_code;
        $curriculum->name = $request->name;
        $curriculum->desc = $request->desc;
        $curriculum->credits = $request->credits;
        $curriculum->is_active = $request->is_active;

        if($curriculum->save()) {
            $courses = Course::whereIn('id', $courses_checked_ids)->get();
            
            $curriculum->courses()->detach($saved_curr_ids);

            foreach($courses as $course) {
                foreach($request->input('subjects_' . $course->id) as $subject_id) {
                    $curriculum->courses()->attach($course->id, ['subject_id' => $subject_id]);
                }
            }
        }
    
        return redirect()->route('admin.curricula.index')
                        ->with('success','Curriculum updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curriculum $curriculum): RedirectResponse
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        $curriculumId = $curriculum->id;

        // Check if Enrollment exist before deleting
        $enrollment = Enrollment::whereHas('curricula', function ($q)use($curriculumId) {
            $q->where('curricula.id', $curriculumId);
        })->get();
        
        // there is existing Enrollment then return to index
        if (count($enrollment) > 0) {
            return redirect()->route('admin.curricula.index')
                        ->with('danger', 'Error in delete: There is an existing enrollment using this curriculum. Please delete the enrollment/s first');
        }

        try{
            DB::beginTransaction();

            $curriculum->courses()->detach();

            $curriculum->delete();

            DB::commit();

            return redirect()->route('admin.curricula.index')
                    ->with('success','Curriculum deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.curricula.index')
                            ->with('danger', $e->getMessage());
        }
    }
}

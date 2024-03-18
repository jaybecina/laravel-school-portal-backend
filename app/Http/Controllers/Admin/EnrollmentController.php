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
use App\Models\Enrollment;
use App\Models\Curriculum;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;


class EnrollmentController extends Controller
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
        $curricula = Curriculum::orderBy('curriculum_code', 'ASC')->get();

        $data = Enrollment::with(['curricula'])->latest()->paginate(5);

        return view('admin.enrollments.index',compact('data', 'curricula'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request): View
    {
        // if(!Auth::user()->hasRole('Super Admin')) {
        //     abort(403, 'Unauthorized access please contact your administrator');
        // }

        $curriculum = Curriculum::find($request->query('curriculum'));

        $courses = Course::orderBy('course_code', 'ASC')->get();

        $subjects = Subject::orderBy('subject_code', 'ASC')->get();

        $students = User::whereHas(
            'roles', function($q){
                $q->where('name', 'Student');
            }
        )->get();

        return view('admin.enrollments.create', compact('curriculum', 'courses', 'subjects', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validateCurriculum(Request $request): RedirectResponse
    {
        request()->validate([
            'curriculum' => 'required',
        ]);

        $curriculum = $request->curriculum;

        // return view('admin.enrollments.create', compact('curriculum'));
        return redirect()->route('admin.enrollments.create', ['curriculum' => $curriculum]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validateEditCurriculum(Request $request): RedirectResponse
    {
        request()->validate([
            'enrollment' => 'required',
            'curriculum_edit' => 'required',
        ]);

        $enrollment = $request->enrollment;
        $curriculum = $request->curriculum_edit;

        // return view('admin.enrollments.create', compact('curriculum'));
        return redirect()->route('admin.enrollments.edit', [$enrollment, 'curriculum' => $curriculum]);
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
            'enrollment_code' => 'required|unique:enrollments',
            'student_id' => 'required',
            'school_year' => 'required',
            'sem' => 'required',
            'remarks' => 'required',
            'course_selected' => 'required',
            'credits' => ['required','numeric', function ($attribute, $value, $fail)use ($request) {
                $required_credits = $request->get('required_credits');
                if ($value > $required_credits) {
                    //  $fail($attribute.'Current credits must not exceed than required credits.');
                    $fail('Current credits must not exceed than required credits.');
                }
            }],
            // 'subjects' => 'required',
        ]);

        $enrollment_exist = Enrollment::where('student_id', $request->student_id)
                    ->where('school_year', $request->school_year)
                    ->where('sem', $request->sem)
                    ->get();

        // Check enrollment exist
        if($enrollment_exist->count() > 0) {
            return redirect()->route('admin.enrollments.create', ['curriculum' => request()->input('curriculum')])
                ->with('danger','Existing enrollment please try again.');
        }


        $course_checked_id = $request->input('course_selected');

        // Check subject if empty
        if(empty($request->input('subjects_' . $course_checked_id))) {
            return redirect()->route('admin.enrollments.create', ['curriculum' => request()->input('curriculum')])
                ->with('danger','No subject selected with the course');
        }

        $enrollment = new Enrollment;
        $enrollment->enrollment_code = $request->enrollment_code;
        $enrollment->student_id = $request->student_id;
        $enrollment->remarks = $request->remarks;
        $enrollment->school_year = $request->school_year;
        $enrollment->sem = $request->sem;
        $enrollment->credits = $request->credits;
        $enrollment->status = "Active";

        if($enrollment->save()) {
            // // Find the "student" role
            // $studentRole = Role::where('name', 'student')->first();

            // // Get all users with the "student" role
            // $student = User::role($studentRole)->inRandomOrder()->first();

            foreach($request->input('subjects_' . $course_checked_id) as $subject_id) {
                $enrollment->curricula()->attach($request->curriculum, [
                    'course_id' => $course_checked_id,
                    'subject_id'  => $subject_id,
                ]);
            }
        }
    
        return redirect()->route('admin.enrollments.index')
                        ->with('success','Enrollment created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function show(Enrollment $enrollment): View
    {
        return view('admin.enrollments.show',compact('enrollment'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Enrollment  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Enrollment $enrollment): View
    {
        // if(!Auth::user()->hasRole('Super Admin')) {
        //     abort(403, 'Unauthorized access please contact your administrator');
        // }

        $select_curriculum = Curriculum::all();

        $curriculumURLParam = Curriculum::find($request->curriculum);

        $isEditCurriculum = false;

        if ($request->has('edit_curriculum')) {
            $edit_curriculum = filter_var($request->edit_curriculum, FILTER_VALIDATE_BOOLEAN);
            $isEditCurriculum = $edit_curriculum;
        }

        $curriculum = $enrollment->curricula->first();

        $courses = Course::orderBy('course_code', 'ASC')->get();

        $subjects = Subject::orderBy('subject_code', 'ASC')->get();

        $students = User::whereHas(
            'roles', function($q){
                $q->where('name', 'Student');
            }
        )->get();

        return view('admin.enrollments.edit', compact('select_curriculum', 'curriculumURLParam', 'isEditCurriculum', 'enrollment', 'curriculum', 'courses', 'subjects', 'students'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enrollment $enrollment): RedirectResponse
    {
        request()->validate([
            'enrollment_code' => 'required',
            'student_id' => 'required',
            'school_year' => 'required',
            'sem' => 'required',
            'remarks' => 'required',
            'course_selected' => 'required',
            'credits' => ['required', 'numeric', function ($attribute, $value, $fail)use ($request) {
                $required_credits = $request->get('required_credits');
                if ($value > $required_credits) {
                    //  $fail($attribute.'Current credits must not exceed than required credits.');
                    $fail('Current credits must not exceed than required credits.');
                }
            }],
            'status' => 'required'
            // 'subjects' => 'required',
        ]);

        $course_checked_id = $request->input('course_selected');

        $isEditCurriculum = false;

        if ($request->has('edit_curriculum_toggle')) {
            $edit_curriculum = filter_var($request->edit_curriculum_toggle, FILTER_VALIDATE_BOOLEAN);
            $isEditCurriculum = $edit_curriculum;
        }

        // Check subject if empty
        if($isEditCurriculum === true) {
            if(empty($request->input('subjects_' . $course_checked_id))) {
                return redirect()->route('admin.enrollments.edit', [$enrollment, 'curriculum' => request()->input('curriculum')])
                    ->with('danger','No subject selected with the course');
            }
        }
    
        // Enrollment::create($request->all());

        // dd($request->all());

        $enrollment->enrollment_code = $request->enrollment_code;
        $enrollment->student_id = $request->student_id;
        $enrollment->remarks = $request->remarks;
        $enrollment->school_year = $request->school_year;
        $enrollment->sem = $request->sem;
        $enrollment->credits = $request->credits;
        $enrollment->status = $request->status;

        if($enrollment->save()) {
            // if($isEditCurriculum === true) { // uncomment if needed
                // // Find the "student" role
                // $studentRole = Role::where('name', 'student')->first();

                // // Get all users with the "student" role
                // $student = User::role($studentRole)->inRandomOrder()->first();

                $enrollment->curricula()->detach($request->saved_curr_id);

                foreach($request->input('subjects_' . $course_checked_id) as $subject_id) {
                    $enrollment->curricula()->attach($request->curriculum, [
                        'course_id' => $course_checked_id,
                        'subject_id'  => $subject_id,
                    ]);
                }
            // }
        }
    
        return redirect()->route('admin.enrollments.index')
                        ->with('success','Enrollment updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enrollment $enrollment): RedirectResponse
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        try{
            DB::beginTransaction();

            $enrollment->curricula()->detach();

            $enrollment->delete();

            DB::commit();

            return redirect()->route('admin.enrollments.index')
                    ->with('success','Enrollment deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.enrollments.index')
                            ->with('danger', $e->getMessage());
        }
    }
}

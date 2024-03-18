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
use App\Models\Subject;
use App\Models\User;
use App\Models\Course;


class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //  $this->middleware('permission:subject-list|subject-create|subject-edit|subject-delete', ['only' => ['index','show']]);
        //  $this->middleware('permission:subject-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:subject-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:subject-delete', ['only' => ['destroy']]);

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
        $data = Subject::latest()->paginate(5);
        return view('admin.subjects.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        // $subject_code = Subject::pluck('subject_code');
        // $prereq_subj = Subject::whereNotIn('prereq_subject_code', $subject_code)->get();

        $teachers = User::whereHas(
            'roles', function($q){
                $q->where('name', 'Teacher');
            }
        )->get();

        $prereq_subj = Subject::where('is_prereq', 0)->get();

        return view('admin.subjects.create', compact('prereq_subj', 'teachers'));
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
            'subject_code' => 'required|unique:subjects',
            'name' => 'required|unique:subjects',
            'start_time' => 'required',
            'end_time' => 'required',
            'day' => 'required',
            'room_no' => 'required',
            'units' => 'required',
            'detail' => 'required',
            'teacher' => 'required',
        ]);

        // dd($request->all());

        // dd($prereq_subj_data);

        // Subject::create($request->all());

        $prereq_subj = $request->prereq_subj;
        $prereq_subj_data = !empty($prereq_subj) ? explode('__', $prereq_subj) : null; 
        $prereq_subject_code = !empty($prereq_subj_data) ? $prereq_subj_data[0] : null;
        $prereq_name = !empty($prereq_subj_data) ? $prereq_subj_data[1] : null;

        $prereq_subj = Subject::where('is_prereq', 0)->get();

        if(!empty($prereq_subj_data)) {
            $is_prereq = Subject::where('subject_code', $prereq_subject_code)->first();
            $is_prereq->is_prereq = true;
            $is_prereq->save();
        }

        $subject = new Subject;
        $subject->subject_code = $request->subject_code;
        $subject->name = $request->name;
        $subject->prereq_subject_code = $prereq_subject_code;
        $subject->prereq_name = $prereq_name;
        $subject->start_time = $request->start_time;
        $subject->end_time = $request->end_time;
        $subject->day = $request->day;
        $subject->room_no = $request->room_no;
        $subject->units = $request->units;
        $subject->detail = $request->detail;
        $subject->teacher_id = $request->teacher;
        $subject->save();
    
        return redirect()->route('admin.subjects.index')
                        ->with('success','Subject created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject): View
    {
        return view('admin.subjects.show',compact('subject'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject): View
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        $prereq_subj = Subject::all();

        $teachers = User::whereHas(
            'roles', function($q){
                $q->where('name', 'Teacher');
            }
        )->get();

        return view('admin.subjects.edit',compact('subject', 'prereq_subj', 'teachers'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject): RedirectResponse
    {
        request()->validate([
            'subject_code' => 'required',
            'name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'day' => 'required',
            'room_no' => 'required',
            'units' => 'required',
            'detail' => 'required',
            'teacher' => 'required',
        ]);
    
        // $subject->update($request->all());

        $prereq_subj = $request->prereq_subj;
        $prereq_subj_data = !empty($prereq_subj) ? explode('__', $prereq_subj) : null; 
        $prereq_subject_code = !empty($prereq_subj_data) ? $prereq_subj_data[0] : null;
        $prereq_name = !empty($prereq_subj_data) ? $prereq_subj_data[1] : null;

        $prereq_subj = Subject::where('is_prereq', 0)->get();

        $subject->subject_code = $request->subject_code;
        $subject->name = $request->name;
        $subject->prereq_subject_code = $prereq_subject_code;
        $subject->prereq_name = $prereq_name;
        $subject->start_time = $request->start_time;
        $subject->end_time = $request->end_time;
        $subject->day = $request->day;
        $subject->room_no = $request->room_no;
        $subject->units = $request->units;
        $subject->detail = $request->detail;
        $subject->teacher_id = $request->teacher;
        
        if($subject->save()) {
            if(count($prereq_subj_data) > 0) {
                $is_prereq = Subject::where('subject_code', $prereq_subject_code)->first();

                if($is_prereq) {
                    $is_prereq->is_prereq = true;
                    $is_prereq->save();
                }
            }
        }
    
        return redirect()->route('admin.subjects.index')
                        ->with('success','Subject updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject): RedirectResponse
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        $subjectId = $subject->id;

        // Check if Course exist before deleting
        $course = Course::whereHas('subjects', function ($q)use($subjectId) {
            $q->where('subjects.id', $subjectId);
        })->get();
        
        // there is existing course then return to index
        if (count($course) > 0) {
            return redirect()->route('admin.subjects.index')
                        ->with('danger', 'Error in delete: There is an existing course using this curriculum. Please delete the course/s first');
        }

        try{
            DB::beginTransaction();

            $subject->delete();

            DB::commit();

            return redirect()->route('admin.subjects.index')
                            ->with('success','Subject deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.subjects.index')
                            ->with('danger', $e->getMessage());
        }
    }
}

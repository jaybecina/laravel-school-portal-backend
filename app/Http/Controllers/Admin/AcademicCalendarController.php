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
use App\Models\AcademicCalendar;


class AcademicCalendarController extends Controller
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
        $data = AcademicCalendar::latest()->paginate(5);
        
        return view('admin.academic-calendar.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.academic-calendar.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|unique:academic_calendars',
            'desc' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $academicCalendar = new AcademicCalendar;
        $academicCalendar->title = $request->title;
        $academicCalendar->desc = $request->desc;
        $academicCalendar->start_date = $request->start_date;
        $academicCalendar->end_date = $request->end_date;
        $academicCalendar->is_active = 1;
        $academicCalendar->save();
    
        return redirect()->route('admin.academic-calendar.index')
                        ->with('success','Academic Calendar saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AcademicCalendar  $academicCalendar
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicCalendar $academicCalendar): View
    {
        return view('admin.academic-calendar.show',compact('academicCalendar'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AcademicCalendar  $academicCalendar
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicCalendar $academicCalendar): View
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        return view('admin.academic-calendar.edit',compact('academicCalendar'));
    }

    public function update(Request $request, AcademicCalendar $academicCalendar): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $academicCalendar->title = $request->title;
        $academicCalendar->desc = $request->desc;
        $academicCalendar->start_date = $request->start_date;
        $academicCalendar->end_date = $request->end_date;
        $academicCalendar->is_active = $request->is_active;
        $academicCalendar->save();
    
        return redirect()->route('admin.academic-calendar.index')
                        ->with('success','Academic Calendar updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicCalendar $academicCalendar): RedirectResponse
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        try{
            DB::beginTransaction();

            $academicCalendar->delete();

            DB::commit();

            return redirect()->route('admin.academic-calendar.index')
                            ->with('success','Academic Calendar deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.academic-calendar.index')
                            ->with('danger', $e->getMessage());
        }
    }
}

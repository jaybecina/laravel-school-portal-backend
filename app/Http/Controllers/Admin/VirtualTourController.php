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
use App\Models\VirtualTour;


class VirtualTourController extends Controller
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
        $data = VirtualTour::latest()->paginate(5);
        
        return view('admin.virtual-tour.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.virtual-tour.create');
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
            'title' => 'required|unique:virtual_tours',
            'desc' => 'required',
            'videoId' => 'required',
        ]);

        $virtualTour = new VirtualTour;
        $virtualTour->title = $request->title;
        $virtualTour->desc = $request->desc;
        $virtualTour->videoId = $request->videoId;
        $virtualTour->is_active = 1;
        $virtualTour->save();
    
        return redirect()->route('admin.virtual-tour.index')
                        ->with('success','Virtual Tour saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VirtualTour  $virtualTour
     * @return \Illuminate\Http\Response
     */
    public function show(VirtualTour $virtualTour): View
    {
        return view('admin.virtual-tour.show',compact('virtualTour'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VirtualTour  $virtualTour
     * @return \Illuminate\Http\Response
     */
    public function edit(VirtualTour $virtualTour): View
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        return view('admin.virtual-tour.edit',compact('virtualTour'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VirtualTour $virtualTour): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'videoId' => 'required',
        ]);

        $virtualTour->title = $request->title;
        $virtualTour->desc = $request->desc;
        $virtualTour->videoId = $request->videoId;
        $virtualTour->is_active = $request->is_active;
        $virtualTour->save();
    
        return redirect()->route('admin.virtual-tour.index')
                        ->with('success','Virtual Tour updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(VirtualTour $virtualTour): RedirectResponse
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        try{
            DB::beginTransaction();

            $virtualTour->delete();

            DB::commit();

            return redirect()->route('admin.virtual-tour.index')
                            ->with('success','Virtual Tour deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.virtual-tour.index')
                            ->with('danger', $e->getMessage());
        }
    }
}

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
use App\Models\Club;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User;


class ClubsController extends Controller
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
        $data = Club::latest()->paginate(5);
        
        return view('admin.clubs.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.clubs.create');
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
            // 'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            'name' => 'required|unique:clubs',
            'details' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $club = new Club;
        if($request->hasFile('image')) {

            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension =  $request->file('image')->getClientOriginalExtension();

            $fileName = $filename.'_' .time().'.'.$extension;

            $fileName = str_replace(' ', '_', $fileName);

            // //remove existing image 
            // $img_str_path = "public/clubs/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // $filePath = $request->file('image')->storeAs('clubs', $fileName, 'public');

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'clubs/'. $fileName;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $path = Storage::disk('do')->put('clubs/'.$fileName, file_get_contents($request->file('image')->getRealPath()));
            // $path = Storage::disk('do')->url($path);

            $club->name = $request->name;
            $club->details = $request->details;
            $club->imagename = $fileName;
            // $club->path = '/storage/' . $filePath;
            $club->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/clubs/'. $fileName;
            $club->is_active = 1;
            $club->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.clubs.index')
                        ->with('success','Club saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function show(Club $club): View
    {
        return view('admin.clubs.show',compact('club'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club): View
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        $students = User::whereHas(
            'roles', function($q){
                $q->where('name', 'Student');
            }
        )->get();

        return view('admin.clubs.edit',compact('club', 'students'));
    }

    public function update(Request $request, Club $club): RedirectResponse
    {
        $request->validate([
            // 'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            'name' => 'required',
            'details' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($request->hasFile('image')) {

            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension =  $request->file('image')->getClientOriginalExtension();

            $fileName = $filename.'_' .time().'.'.$extension;

            $fileName = str_replace(' ', '_', $fileName);

            // //remove existing image 
            // $img_str_path = "public/clubs/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // $filePath = $request->file('image')->storeAs('clubs', $fileName, 'public');

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'clubs/'. $club->imagename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            }

            // $filePath = $request->file('image')->storeAs('clubs', $fileName, 'public');

            $path = Storage::disk('do')->put('clubs/'.$fileName, file_get_contents($request->file('image')->getRealPath()));
            // $path = Storage::disk('do')->url($path);

            $club->name = $request->name;
            $club->details = $request->details;
            $club->imagename = $fileName;
            // $club->path = '/storage/' . $filePath;
            $club->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/clubs/'. $fileName;
            $club->is_active = $request->is_active;
            $club->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.clubs.index')
                        ->with('success','Club updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club): RedirectResponse
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        try{
            DB::beginTransaction();

            // $img_str_path = "public/clubs/".$club->filename;
            // // dd($img_str_path);
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'clubs/'. $club->imagename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $club->delete();

            DB::commit();

            return redirect()->route('admin.clubs.index')
                            ->with('success','Club deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.clubs.index')
                            ->with('danger', $e->getMessage());
        }
    }
}

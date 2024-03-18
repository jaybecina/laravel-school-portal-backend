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
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class EventController extends Controller
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
        $data = Event::latest()->paginate(5);
        
        return view('admin.events.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.events.create');
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
            'name' => 'required|unique:events',
            'details' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'speaker_name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $event = new Event;
        if($request->hasFile('image')) {

            $file = $request->file('image');
            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension =  $request->file('image')->getClientOriginalExtension();

            $fileName = $filename.'_' .time().'.'.$extension;

            $fileName = str_replace(' ', '_', $fileName);

            // // local
            // //remove existing image 
            // $img_str_path = "public/events/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'events/'. $fileName;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $path = Storage::disk('do')->put('events/'.$fileName, file_get_contents($request->file('image')->getRealPath()));
            // $path = Storage::disk('do')->url($path);

            $event->name = $request->name;
            $event->details = $request->details;
            $event->start_date = $request->start_date;
            $event->end_date = $request->end_date;
            $event->speaker_name = $request->speaker_name;
            $event->imagename = $fileName;
            $event->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/events/'. $fileName;
            $event->is_active = 1;
            $event->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.events.index')
                        ->with('success','Event saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event): View
    {
        return view('admin.events.show',compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event): View
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        return view('admin.events.edit',compact('event'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $request->validate([
            // 'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            'name' => 'required',
            'details' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'speaker_name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($request->hasFile('image')) {

            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension =  $request->file('image')->getClientOriginalExtension();

            $fileName = $filename.'_' .time().'.'.$extension;

            $fileName = str_replace(' ', '_', $fileName);

            // //remove existing image 
            // $img_str_path = "public/events/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'events/'. $event->imagename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            }

            // $filePath = $request->file('image')->storeAs('events', $fileName, 'public');

            $path = Storage::disk('do')->put('events/'.$fileName, file_get_contents($request->file('image')->getRealPath()));
            // $path = Storage::disk('do')->url($path);

            $event->name = $request->name;
            $event->details = $request->details;
            $event->start_date = $request->start_date;
            $event->end_date = $request->end_date;
            $event->speaker_name = $request->speaker_name;
            $event->imagename = $fileName;
            // $event->path = '/storage/' . $filePath;
            $event->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/events/'. $fileName;
            $event->is_active = $request->is_active;
            $event->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.events.index')
                        ->with('success','Event updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event): RedirectResponse
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        try{
            DB::beginTransaction();

            // $img_str_path = "public/events/".$event->filename;
            // // dd($img_str_path);
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'events/'. $event->imagename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $event->delete();

            DB::commit();

            return redirect()->route('admin.events.index')
                            ->with('success','Event deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.events.index')
                            ->with('danger', $e->getMessage());
        }
    }
}

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
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class TestimonialController extends Controller
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
        $data = Testimonial::latest()->paginate(5);
        
        return view('admin.testimonial.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.testimonial.create');
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
            'title' => 'required|unique:testimonials',
            'body' => 'required',
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $testimonial = new Testimonial;
        if($request->hasFile('image')) {

            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension =  $request->file('image')->getClientOriginalExtension();

            $fileName = $filename.'_' .time().'.'.$extension;

            $fileName = str_replace(' ', '_', $fileName);

            // //remove existing image 
            // $img_str_path = "public/testimonials/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // $filePath = $request->file('image')->storeAs('testimonials', $fileName, 'public');

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'testimonials/'. $fileName;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $path = Storage::disk('do')->put('testimonials/'.$fileName, file_get_contents($request->file('image')->getRealPath()));
            // $path = Storage::disk('do')->url($path);

            $testimonial->title = $request->title;
            $testimonial->body = $request->body;
            $testimonial->name = $request->name;
            $testimonial->job = $request->job;
            $testimonial->imagename = $fileName;
            // $testimonial->path = '/storage/' . $filePath;
            $testimonial->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/testimonials/'. $fileName;
            $testimonial->is_active = 1;
            $testimonial->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.testimonial.index')
                        ->with('success','Testimonial saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function show(Testimonial $testimonial): View
    {
        return view('admin.testimonial.show',compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function edit(Testimonial $testimonial): View
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        return view('admin.testimonial.edit',compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $request->validate([
            // 'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            'title' => 'required',
            'body' => 'required',
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($request->hasFile('image')) {

            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension =  $request->file('image')->getClientOriginalExtension();

            $fileName = $filename.'_' .time().'.'.$extension;

            $fileName = str_replace(' ', '_', $fileName);

            // //remove existing image 
            // $img_str_path = "public/testimonials/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // $filePath = $request->file('image')->storeAs('testimonials', $fileName, 'public');

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'testimonials/'. $testimonial->imagename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $path = Storage::disk('do')->put('testimonials/'.$fileName, file_get_contents($request->file('image')->getRealPath()));
            // $path = Storage::disk('do')->url($path);

            $testimonial->title = $request->title;
            $testimonial->body = $request->body;
            $testimonial->name = $request->name;
            $testimonial->job = $request->job;
            $testimonial->imagename = $fileName;
            // $testimonial->path = '/storage/' . $filePath;
            $testimonial->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/testimonials/'. $fileName;
            $testimonial->is_active = $request->is_active;
            $testimonial->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.testimonial.index')
                        ->with('success','Testimonial updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        try{
            DB::beginTransaction();

            // $img_str_path = "public/testimonials/".$testimonial->filename;
            // // dd($img_str_path);
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'testimonials/'. $testimonial->imagename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $testimonial->delete();

            DB::commit();

            return redirect()->route('admin.testimonial.index')
                            ->with('success','Testimonial deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.testimonial.index')
                            ->with('danger', $e->getMessage());
        }
    }
}

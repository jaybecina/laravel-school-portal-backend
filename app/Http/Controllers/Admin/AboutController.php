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
use App\Models\About;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class AboutController extends Controller
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
        $data = About::latest()->paginate(5);
        
        return view('admin.about.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.about.create');
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
            'title' => 'required|unique:abouts',
            'body' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Check if the about table is empty
        $existingAbout = About::first();
    
        if ($existingAbout) {
            // If there's already data in the about table, return an error or redirect as needed
            return redirect()->route('admin.about.create')->with('danger','About section already exists');
        }

        $about = new About;
        if($request->hasFile('image')) {

            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension =  $request->file('image')->getClientOriginalExtension();

            $fileName = $filename.'_' .time().'.'.$extension;

            $fileName = str_replace(' ', '_', $fileName);

            // //remove existing image 
            // $img_str_path = "public/about/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // $filePath = $request->file('image')->storeAs('about', $fileName, 'public');

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'about/'. $fileName;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $path = Storage::disk('do')->put('about/'.$fileName, file_get_contents($request->file('image')->getRealPath()));
            // $path = Storage::disk('do')->url($path);

            $about->title = $request->title;
            $about->body = $request->body;
            $about->imagename = $fileName;
            // $about->path = '/storage/' . $filePath;
            $about->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/about/'. $fileName;
            $about->is_active = 1;
            $about->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.about.index')
                        ->with('success','About saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\About  $about
     * @return \Illuminate\Http\Response
     */
    public function show(About $about): View
    {
        return view('admin.about.show',compact('about'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\About  $about
     * @return \Illuminate\Http\Response
     */
    public function edit(About $about): View
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        return view('admin.about.edit',compact('about'));
    }

    public function update(Request $request, About $about): RedirectResponse
    {
        $request->validate([
            // 'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            'title' => 'required',
            'body' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($request->hasFile('image')) {

            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension =  $request->file('image')->getClientOriginalExtension();

            $fileName = $filename.'_' .time().'.'.$extension;

            $fileName = str_replace(' ', '_', $fileName);

            // //remove existing image 
            // $img_str_path = "public/about/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // $filePath = $request->file('image')->storeAs('about', $fileName, 'public');

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'about/'. $about->imagename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $path = Storage::disk('do')->put('about/'.$fileName, file_get_contents($request->file('image')->getRealPath()));
            // $path = Storage::disk('do')->url($path);


            $about->title = $request->title;
            $about->body = $request->body;
            $about->imagename = $fileName;
            // $about->path = '/storage/' . $filePath;
            $about->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/about/'. $fileName;
            $about->is_active = $request->is_active;
            $about->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.about.index')
                        ->with('success','About updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(About $about): RedirectResponse
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        try{
            DB::beginTransaction();

            // $img_str_path = "public/about/".$about->filename;
            // // dd($img_str_path);
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'about/'. $about->imagename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $about->delete();

            DB::commit();

            return redirect()->route('admin.about.index')
                            ->with('success','About deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.about.index')
                            ->with('danger', $e->getMessage());
        }
    }
}

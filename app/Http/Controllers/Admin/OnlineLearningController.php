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
use App\Models\OnlineLearning;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class OnlineLearningController extends Controller
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
        $data = OnlineLearning::latest()->paginate(5);
        
        return view('admin.online-learning.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.online-learning.create');
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
            // 'filename' => 'required|unique:student_resources',
            // 'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            'title' => 'required|unique:student_resources',
            'desc' => 'required',
            'video' => 'required|mimes:mp4,mov,avi,wmv|max:50000',
        ]);

        $onlineLearning = new OnlineLearning;
        if($request->file('video')) {
            $fileNameWithExt = $request->file('video')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension =  $request->file('video')->getClientOriginalExtension();

            $fileName = $filename.'_' .time().'.'.$extension;

            $fileName = str_replace(' ', '_', $fileName);

            // //remove existing image 
            // $img_str_path = "public/online_learning/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // $filePath = $request->file('video')->storeAs('online_learning', $fileName, 'public');

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'online_learning/'. $fileName;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $path = Storage::disk('do')->put('online_learning/'.$fileName, file_get_contents($request->file('video')->getRealPath()));

            $onlineLearning->title = $request->title;
            $onlineLearning->desc = $request->desc;
            $onlineLearning->filename = $fileName;
            // $onlineLearning->path = '/storage/' . $filePath;
            $onlineLearning->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/online_learning/'. $fileName;
            $onlineLearning->mime_type = $request->file('video')->getMimeType();
            $onlineLearning->filesize = $request->file('video')->getSize();
            $onlineLearning->is_active = 1;
            $onlineLearning->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.online-learning.index')
                        ->with('success','Online learning saved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(OnlineLearning $onlineLearning): View
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        return view('admin.online-learning.edit',compact('onlineLearning'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OnlineLearning $onlineLearning): RedirectResponse
    {
        $request->validate([
            // 'filename' => 'required|unique:student_resources',
            // 'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            'title' => 'required',
            'desc' => 'required',
            'video' => 'required|mimes:mp4,mov,avi,wmv|max:50000',
        ]);

        if($request->file('video')) {
            $fileNameWithExt = $request->file('video')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension =  $request->file('video')->getClientOriginalExtension();

            $fileName = $filename.'_' .time().'.'.$extension;

            $fileName = str_replace(' ', '_', $fileName);

            // //remove existing image 
            // $img_str_path = "public/online_learning/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // $filePath = $request->file('video')->storeAs('online_learning', $fileName, 'public');

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'online_learning/'. $onlineLearning->filename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $path = Storage::disk('do')->put('online_learning/'.$fileName, file_get_contents($request->file('video')->getRealPath()));

            $onlineLearning->title = $request->title;
            $onlineLearning->desc = $request->desc;
            $onlineLearning->filename = $fileName;
            // $onlineLearning->path = '/storage/' . $filePath;
            $onlineLearning->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/online_learning/'. $fileName;
            $onlineLearning->mime_type = $request->file('video')->getMimeType();
            $onlineLearning->filesize = $request->file('video')->getSize();
            $onlineLearning->is_active = 1;
            $onlineLearning->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.online-learning.index')
                        ->with('success','Online learning updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(OnlineLearning $onlineLearning): RedirectResponse
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        try{
            DB::beginTransaction();

            // $img_str_path = "public/online_learning/".$onlineLearning->filename;
            // // dd($img_str_path);
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'online_learning/'. $onlineLearning->filename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $onlineLearning->delete();

            DB::commit();

            return redirect()->route('admin.online-learning.index')
                            ->with('success','Online learning deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.online-learning.index')
                            ->with('danger', $e->getMessage());
        }
    }
}

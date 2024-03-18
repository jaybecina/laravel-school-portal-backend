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
use App\Models\StudentHandbook;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class StudentHandbookController extends Controller
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
        $data = StudentHandbook::latest()->paginate(5);
        
        return view('admin.student-handbook.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.student-handbook.create');
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
            // 'filename' => 'required|unique:student_handbook',
            // 'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            'title' => 'required|unique:student_handbooks',
            'desc' => 'required',
            'file' => 'required|mimes:pdf|max:2048'
        ]);

        $studentHandbook = new StudentHandbook;
        if($request->file()) {
            $pdfParser = new Parser();
            $pdf = $pdfParser->parseFile($request->file->path());
            $content = $pdf->getText();

            $fileNameWithExt = $request->file->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension =  $request->file->getClientOriginalExtension();

            $fileName = $filename.'_' .time().'.'.$extension;

            $fileName = str_replace(' ', '_', $fileName);

            // //remove existing image 
            // $img_str_path = "public/student_handbook/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // $filePath = $request->file('file')->storeAs('student_handbook', $fileName, 'public');

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'student_handbook/'. $fileName;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $path = Storage::disk('do')->put('student_handbook/'.$fileName, file_get_contents($request->file('file')->getRealPath()));
            // $path = Storage::disk('do')->url($path);

            $studentHandbook->title = $request->title;
            $studentHandbook->desc = $request->desc;
            $studentHandbook->filename = $fileName;
            // $studentHandbook->path = '/storage/' . $filePath;
            $studentHandbook->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/student_handbook/'. $fileName;
            $studentHandbook->mime_type = $request->file->getMimeType();
            $studentHandbook->filesize = $request->file->getSize();
            $studentHandbook->content = $content;
            $studentHandbook->is_active = 1;
            $studentHandbook->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.student-handbook.index')
                        ->with('success','Student handbook saved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StudentHandbook  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentHandbook $studentHandbook): View
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        return view('admin.student-handbook.edit',compact('studentHandbook'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentHandbook $studentHandbook): RedirectResponse
    {
        $request->validate([
            // 'filename' => 'required|unique:student_handbook',
            // 'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            'title' => 'required',
            'desc' => 'required',
            'file' => 'required|mimes:pdf|max:2048'
        ]);

        if($request->file()) {
            $pdfParser = new Parser();
            $pdf = $pdfParser->parseFile($request->file->path());
            $content = $pdf->getText();

            $fileNameWithExt = $request->file->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension =  $request->file->getClientOriginalExtension();

            $fileName = $filename.'_' .time().'.'.$extension;

            $fileName = str_replace(' ', '_', $fileName);

            // //remove existing image 
            // $img_str_path = "public/student_handbook/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // $filePath = $request->file('file')->storeAs('student_handbook', $fileName, 'public');

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'student_handbook/'. $studentHandbook->filename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $path = Storage::disk('do')->put('student_handbook/'.$fileName, file_get_contents($request->file('file')->getRealPath()));
            // $path = Storage::disk('do')->url($path);

            $studentHandbook->title = $request->title;
            $studentHandbook->desc = $request->desc;
            $studentHandbook->filename = $fileName;
            // $studentHandbook->path = '/storage/' . $filePath;
            $studentHandbook->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/student_handbook/'. $fileName;
            $studentHandbook->mime_type = $request->file->getMimeType();
            $studentHandbook->filesize = $request->file->getSize();
            $studentHandbook->content = $content;
            $studentHandbook->is_active = 1;
            $studentHandbook->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.student-handbook.index')
                        ->with('success','Student handbook updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentHandbook $studentHandbook): RedirectResponse
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        try{
            DB::beginTransaction();

            // $img_str_path = "public/student_handbook/".$studentHandbook->filename;
            // // dd($img_str_path);
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'student_handbook/'. $studentHandbook->filename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $studentHandbook->delete();

            DB::commit();

            return redirect()->route('admin.student-handbook.index')
                            ->with('success','Student handbook deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.student-handbook.index')
                            ->with('danger', $e->getMessage());
        }
    }
}

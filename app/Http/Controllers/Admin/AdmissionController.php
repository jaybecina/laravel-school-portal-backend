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
use App\Models\Admission;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class AdmissionController extends Controller
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
        $data = Admission::latest()->paginate(5);
        
        return view('admin.admission.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.admission.create');
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
            // 'filename' => 'required|unique:admission',
            // 'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            'title' => 'required|unique:admissions',
            'desc' => 'required',
            'file' => 'required|mimes:pdf|max:2048'
        ]);

        $admission = new Admission;
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
            // $img_str_path = "public/admission/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // $filePath = $request->file('file')->storeAs('admission', $fileName, 'public');

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'admission/'. $fileName;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $path = Storage::disk('do')->put('admission/'.$fileName, file_get_contents($request->file('file')->getRealPath()));
            // $path = Storage::disk('do')->url($path);

            $admission->title = $request->title;
            $admission->desc = $request->desc;
            $admission->filename = $fileName;
            // $admission->path = '/storage/' . $filePath;
            $admission->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/admission/'. $fileName;
            $admission->mime_type = $request->file->getMimeType();
            $admission->filesize = $request->file->getSize();
            $admission->content = $content;
            $admission->is_active = 1;
            $admission->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.admission.index')
                        ->with('success','Admission saved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(Admission $admission): View
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        return view('admin.admission.edit',compact('admission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admission $admission): RedirectResponse
    {
        $request->validate([
            // 'filename' => 'required|unique:admission',
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
            // $img_str_path = "public/admission/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // $filePath = $request->file('file')->storeAs('admission', $fileName, 'public');

             // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
             $spaces = Storage::disk('do'); 

             // Check if the file exists
             $img_str_path = 'admission/'. $admission->filename;
             if ($spaces->exists($img_str_path)) {
                 $spaces->delete($img_str_path);
             } 
 
             $path = Storage::disk('do')->put('admission/'.$fileName, file_get_contents($request->file('file')->getRealPath()));
             // $path = Storage::disk('do')->url($path);

            $admission->title = $request->title;
            $admission->desc = $request->desc;
            $admission->filename = $fileName;
            // $admission->path = '/storage/' . $filePath;
            $admission->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/admission/'. $fileName;
            $admission->mime_type = $request->file->getMimeType();
            $admission->filesize = $request->file->getSize();
            $admission->content = $content;
            $admission->is_active = 1;
            $admission->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.admission.index')
                        ->with('success','Admission updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admission $admission): RedirectResponse
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        try{
            DB::beginTransaction();

            // $img_str_path = "public/admission/".$admission->filename;
            // // dd($img_str_path);
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'admission/'. $admission->filename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $admission->delete();

            DB::commit();

            return redirect()->route('admin.admission.index')
                            ->with('success','Admission deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.admission.index')
                            ->with('danger', $e->getMessage());
        }
    }
}

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
use App\Models\LibraryResource;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class LibraryResourceController extends Controller
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
        $data = LibraryResource::latest()->paginate(5);
        
        return view('admin.library-resources.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.library-resources.create');
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
            // 'filename' => 'required|unique:library_resources',
            // 'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            'title' => 'required|unique:library_resources',
            'desc' => 'required',
            'file' => 'required|mimes:pdf|max:2048'
        ]);

        $libraryResource = new LibraryResource;
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
            // $img_str_path = "public/library_resources/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // $filePath = $request->file('file')->storeAs('library_resources', $fileName, 'public');

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'library_resources/'. $fileName;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $path = Storage::disk('do')->put('library_resources/'.$fileName, file_get_contents($request->file('file')->getRealPath()));
            // $path = Storage::disk('do')->url($path);

            $libraryResource->title = $request->title;
            $libraryResource->desc = $request->desc;
            $libraryResource->filename = $fileName;
            // $libraryResource->path = '/storage/' . $filePath;
            $libraryResource->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/library_resources/'. $fileName;
            $libraryResource->mime_type = $request->file->getMimeType();
            $libraryResource->filesize = $request->file->getSize();
            $libraryResource->content = $content;
            $libraryResource->is_active = 1;
            $libraryResource->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.library-resources.index')
                        ->with('success','Library resource saved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(LibraryResource $libraryResource): View
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        return view('admin.library-resources.edit',compact('libraryResource'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LibraryResource $libraryResource): RedirectResponse
    {
        $request->validate([
            // 'filename' => 'required|unique:library_resources',
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
            // $img_str_path = "public/library_resources/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // $filePath = $request->file('file')->storeAs('library_resources', $fileName, 'public');

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'library_resources/'. $libraryResource->filename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $path = Storage::disk('do')->put('library_resources/'.$fileName, file_get_contents($request->file('file')->getRealPath()));
            // $path = Storage::disk('do')->url($path);

            $libraryResource->title = $request->title;
            $libraryResource->desc = $request->desc;
            $libraryResource->filename = $fileName;
            // $libraryResource->path = '/storage/' . $filePath;
            $libraryResource->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/library_resources/'. $fileName;
            $libraryResource->mime_type = $request->file->getMimeType();
            $libraryResource->filesize = $request->file->getSize();
            $libraryResource->content = $content;
            $libraryResource->is_active = 1;
            $libraryResource->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.library-resources.index')
                        ->with('success','Library resource updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(LibraryResource $libraryResource): RedirectResponse
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        try{
            DB::beginTransaction();

            // $img_str_path = "public/library_resources/".$libraryResource->filename;
            // // dd($img_str_path);
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'library_resources/'. $libraryResource->filename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $libraryResource->delete();

            DB::commit();

            return redirect()->route('admin.library-resources.index')
                            ->with('success','Library resource deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.library-resources.index')
                            ->with('danger', $e->getMessage());
        }
    }
}

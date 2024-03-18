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
use App\Models\BannerSlide;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class BannerSlideController extends Controller
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
        $data = BannerSlide::latest()->paginate(5);
        
        return view('admin.banner-slide.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.banner-slide.create');
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
            'title' => 'required|unique:banner_slides',
            'body' => 'required',
            'link' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $bannerSlide = new BannerSlide;
        if($request->hasFile('image')) {

            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension =  $request->file('image')->getClientOriginalExtension();

            $fileName = $filename.'_' .time().'.'.$extension;

            $fileName = str_replace(' ', '_', $fileName);

            // //remove existing image 
            // $img_str_path = "public/banner_slides/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // $filePath = $request->file('image')->storeAs('banner_slides', $fileName, 'public');

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'banner_slides/'. $fileName;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $path = Storage::disk('do')->put('banner_slides/'.$fileName, file_get_contents($request->file('image')->getRealPath()));
            // $path = Storage::disk('do')->url($path);

            $bannerSlide->title = $request->title;
            $bannerSlide->body = $request->body;
            $bannerSlide->link = $request->link;
            $bannerSlide->imagename = $fileName;
            // $bannerSlide->path = '/storage/' . $filePath;
            $bannerSlide->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/banner_slides/'. $fileName;
            $bannerSlide->is_active = 1;
            $bannerSlide->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.banner-slide.index')
                        ->with('success','BannerSlide saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BannerSlide  $bannerSlide
     * @return \Illuminate\Http\Response
     */
    public function show(BannerSlide $bannerSlide): View
    {
        return view('admin.banner-slide.show',compact('bannerSlide'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BannerSlide  $bannerSlide
     * @return \Illuminate\Http\Response
     */
    public function edit(BannerSlide $bannerSlide): View
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        return view('admin.banner-slide.edit',compact('bannerSlide'));
    }

    public function update(Request $request, BannerSlide $bannerSlide): RedirectResponse
    {
        $request->validate([
            // 'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            'title' => 'required',
            'body' => 'required',
            'link' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($request->hasFile('image')) {

            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension =  $request->file('image')->getClientOriginalExtension();

            $fileName = $filename.'_' .time().'.'.$extension;

            $fileName = str_replace(' ', '_', $fileName);

            // //remove existing image 
            // $img_str_path = "public/banner_slides/".$fileName;
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // $filePath = $request->file('image')->storeAs('banner_slides', $fileName, 'public');

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'banner_slides/'. $bannerSlide->imagename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $path = Storage::disk('do')->put('banner_slides/'.$fileName, file_get_contents($request->file('image')->getRealPath()));
            // $path = Storage::disk('do')->url($path);

            $bannerSlide->title = $request->title;
            $bannerSlide->body = $request->body;
            $bannerSlide->link = $request->link;
            $bannerSlide->imagename = $fileName;
            // $bannerSlide->path = '/storage/' . $filePath;
            $bannerSlide->path = 'https://kll-portal-spaces.sgp1.digitaloceanspaces.com/banner_slides/'. $fileName;
            $bannerSlide->is_active = $request->is_active;
            $bannerSlide->save();
            // return back()
            // ->with('success','File has been uploaded.')
            // ->with('file', $fileName);
        }
    
        return redirect()->route('admin.banner-slide.index')
                        ->with('success','Banner Slide updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(BannerSlide $bannerSlide): RedirectResponse
    {
        if(!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized access please contact your administrator');
        }

        try{
            DB::beginTransaction();

            // $img_str_path = "public/banner_slides/".$bannerSlide->filename;
            // // dd($img_str_path);
            // if(Storage::exists($img_str_path)){
            //     Storage::delete($img_str_path);
            // }

            // Assuming 'do' is the name of your DigitalOcean Spaces disk in filesystems.php
            $spaces = Storage::disk('do'); 

            // Check if the file exists
            $img_str_path = 'banner_slides/'. $bannerSlide->imagename;
            if ($spaces->exists($img_str_path)) {
                $spaces->delete($img_str_path);
            } 

            $bannerSlide->delete();

            DB::commit();

            return redirect()->route('admin.banner-slide.index')
                            ->with('success','Banner Slide deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.banner-slide.index')
                            ->with('danger', $e->getMessage());
        }
    }
}

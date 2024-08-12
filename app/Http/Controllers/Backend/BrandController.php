<?php

namespace App\Http\Controllers\Backend;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use function Termwind\render;
use App\DataTables\BrandDataTable;
use App\Http\Controllers\Controller;
use App\Traits\ImageUploadTrait;

class BrandController extends Controller
{

    use ImageUploadTrait;
    public function index(BrandDataTable $datatable)
    {
        return $datatable->render('admin.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
          'logo'=> ['required','image','max:2048'],
          'name'=> ['required','max:200'],
          'is_featured' => ['required'],  
          'status'=> ['required'],
        ]);

        $logoPath = $this->uploadImage($request, 'logo', 'uploads');
        $brand = new Brand();

        $brand->logo = $logoPath;
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->title);
        $brand->is_featured = $request->is_featured;
        $brand->status = $request->status;
        $brand->save();

        toastr('created successfully', 'success');
        return redirect()->route('admin.brand.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
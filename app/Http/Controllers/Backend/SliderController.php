<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SliderDataTable;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ImageUploadTrait;

class SliderController extends Controller
{
    //----------------- PANGGIL CLASS ImageUploadTrait -----------//
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(SliderDataTable $dataTable)
    {
        return $dataTable->render('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //------------- VLIDASI INPUT FIELDS PADA CREATE SLIDER FORM -------// 
        $request->validate([
            'banner' => ['required','max:2048','image'],
            'type' => ['max:200','string'],
            'title' => ['max:200','required'],
            'starting_price' => ['max:200'],
            'btn_url' => ['url'],
            'serial' => ['required','integer'],
            'status' => ['required'],
        ]);

        //-------- Menetapkan Data Form ke Properti Model ---------//
        $slider = new Slider();
        
        $imagePath =  $this->uploadImage($request, 'banner', 'uploads');
        
        $slider->banner = $imagePath;
        $slider->type = $request->type;
        $slider->title = $request->title;
        $slider->starting_price = $request->starting_price;
        $slider->btn_url = $request->btn_url;
        $slider->serial = $request->serial;
        $slider->status = $request->status;
        $slider->save();

        toastr('Created Succesfully','success');
        return redirect()->back();
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
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'banner' => ['image','nullable'],
            'type' => ['max:200','string'],
            'title' => ['max:200','required'],
            'starting_price' => ['max:200'],
            'btn_url' => ['url'],
            'serial' => ['required','integer'],
            'status' => ['required'],
        ]);

        $slider = Slider::findOrFail($id);
        
        //----------- IMAGE UPDATE TRAIT ----------------------------------//
        $imagePath =  $this->updateImage($request, 'banner', 'uploads', $slider->banner);
        
        // $slider->banner = empty($imagePath) ? $imagePath : $slider->banner;
        $slider->banner = (!empty($imagePath) ? $imagePath : $slider->banner);
        $slider->type = $request->type;
        $slider->title = $request->title;
        $slider->starting_price = $request->starting_price;
        $slider->btn_url = $request->btn_url;
        $slider->serial = $request->serial;
        $slider->status = $request->status;
        $slider->save();

        toastr('Updated Succesfully','success');
        return redirect()->route('admin.slider.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);
        $this->deleteImage($slider->banner);
        $slider->delete();

        return response(['status'=>'success','message'=> 'Deleted Successfully']);
    }
}
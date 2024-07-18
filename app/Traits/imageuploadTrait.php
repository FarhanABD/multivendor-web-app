<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait ImageUploadTrait {

    public function uploadImage(Request $request, $inputName, $path){
        if($request->hasFile($inputName)){
    
             //------------ FUNCTION UNTUK MENYIMPAN GAMBAR YANG DIUPLOAD -----------------//
            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_'.uniqid().'.'.$ext;
            $image->move(public_path($path),$imageName);
    
            return $path.'/'.$imageName;
           }
    }
}
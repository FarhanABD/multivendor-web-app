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

    public function updateImage(Request $request, $oldPath=null, $inputName, $path){
        if($request->hasFile('image')){
            if(File::exists(public_path($oldPath))){
                File::delete(public_path($oldPath));
            }
    
             //------------ FUNCTION UNTUK MENYIMPAN GAMBAR YANG DIUPLOAD -----------------//
            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_'.uniqid().'.'.$ext;
            $image->move(public_path($path),$imageName);
    
            return $path.'/'.$imageName;
           }
    }

    //------ HANDLE DELETE FILE IMAGE -----------------// 
    public function deleteImage(String $Path){
        
            if(File::exists(public_path($Path))){
                File::delete(public_path($Path));
           }
    }
    
}
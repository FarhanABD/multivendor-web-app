<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class ProfileController extends Controller
{
    public function index(){
        return view('admin.profile.index');
    }

    public function updateProfile(Request $request){
        //--------- VALIDASI DATA --------------//
       $request->validate([
        'name' => ['required', 'max:100'],
        'email' => ['required', 'email','unique:users,email,'.Auth::user()->id],
        'image' => ['image','max:2048']
       ]);
       //-------------------------------------// 

       //------ Kondisi menampilkan gambar default saat gambar kosong ----------//
       $user = Auth::user();
       if($request->hasFile('image')){
        if(File::exists(public_path($user->image))){
            File::delete(public_path($user->image));
        }
        //----------------------------------------------//

         //------------ FUNCTION UNTUK MENYIMPAN GAMBAR YANG DIUPLOAD -----------------//
        $image = $request->image;
        $imageName = rand().'_'.$image->getClientOriginalName();
        $image->move(public_path('uploads'),$imageName);

        $path = "/uploads/".$imageName;
        $user->image = $path;
       }
       
       //--------- UPDATE USERNAME & EMAIL -------------//
       $user->name = $request->name;
       $user->email = $request->email;
       $user->save();
       toastr()->success('Profile updated succesfully');
       return redirect()->back();
    }

    public function updatePassword(Request $request){
        $request->validate([
            'current_password' => ['required','current_password'],
            'password' => ['required','confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password)
        ]);
        toastr()->success('Password updated succesfully');
        return redirect()->back();
    }
}
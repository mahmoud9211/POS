<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit ()
    {
        $details = User::findOrFail(auth()->id());

        return view ('profile.edit',compact('details'));
    }

    public function update (Request $request, $id)
    {
        $validation = $request->validate([
           'name' => 'required',Rule::unique('users')->ignore($id),
           'email' => 'required',Rule::unique('users')->ignore($id),
          ]);

          $user = User::findOrFail($id);

          if($request->photo)
          {
              if($user->photo != null)
              {
                  
              Storage::disk('public_path')->delete('/profile_images/'.$user->photo);

              Image::make($request->photo)->resize(300, 200)->save(public_path('uploads/profile_images/'. $request->photo->hashName()));



              }

             // $request_data['photo'] = $request->photo->hashName();
          else{
                 
            Image::make($request->photo)->resize(300, 200)->save(public_path('uploads/profile_images/'. $request->photo->hashName()));


          }

          User::findOrFail($id)->update([
           'name' => $request->name,
           'email' => $request->email,
           'photo' => $request->photo->hashName()
          ]);

          $msg = ([
            'message' => __('main.updated_successfully'),
            'alert-type' => 'success'
        ]);
        return redirect()->to('/')->with($msg);

    }else {

        User::findOrFail($id)->update([
            'name' => $request->name,
            'email' => $request->email
           ]);

           $msg = ([
            'message' => __('main.updated_successfully'),
            'alert-type' => 'success'
        ]);
        return redirect()->to('/')->with($msg);

    }
}




public function change_password_page ()

{
   return view ('profile.change_password');
}

public function change_password_process (Request $request)
{

    $validation = $request->validate([
      
        'old_password' => 'required',
        'password' => 'required|confirmed'
    
    ]);

    $password = Auth::user()->password;

    if(Hash::check($request->old_password,$password))
    {
      if(Hash::check($request->password,$password))
      {
          $msg = ([
              'message' => __("main.New password Can't be the same like Current password!"),
              'alert-type' => 'error'
          ]);
          return redirect()->back()->with($msg);

      }else{

        User::FindOrFail(Auth::user()->id)->update([
            'password' => Hash::make($request->password)
        ]);

        Auth::logout();

        $msg = ([
            'message' => "Password Changed Successfully",
            'alert-type' => 'success'
        ]);
        return redirect()->route('login')->with($msg);

      }
    }
    else{

        return redirect()->back();
    }
}



}

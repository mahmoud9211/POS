<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
class usersController extends Controller
{

    public function __construct()
    {
       $this->middleware(['permission:users_read'])->only('index');
       $this->middleware(['permission:users_create'])->only('store');
       $this->middleware(['permission:users_update'])->only('edit','update');
       $this->middleware(['permission:users_delete'])->only('delete');

    }
   
    public function index(Request $request)
    {

        $users = User::whereRoleIs('admin')->when($request->search,function($query) use ($request){

            return $query->where('name','LIKE','%'. $request->search .'%');
        })->latest()->paginate(5);
        return view ('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('users.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
          'name' => 'required',
          'email' => 'required|unique:users',
          'password' => 'required|confirmed',
          'photo' => 'image',
          'permissions' => 'required|min:1'
        ]);

        $request_data = $request->except(['password','password_confirmation','permissions','image']);
        $request_data['password'] = bcrypt($request->password);
    

     if($request->photo)
     {
        Image::make($request->photo)->resize(300, 200)->save(public_path('uploads/profile_images/'. $request->photo->hashName()));

        $request_data['photo'] = $request->photo->hashName();

     }

     $user = User::create($request_data);

        $user->attachRole('admin');
        

        $user->syncPermissions($request->permissions);

        $msg = ([
            'message' => __('main.added_successfully'),
            'alert-type' => 'success'
        ]);
        return redirect()->route('dashboard.users.index')->with($msg);
        
    }

  
    public function show($id)
    {
        //
    }

  
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view ('users.edit',compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $validation = $request->validate([
            'name' => 'required',
            'email' => ['required',Rule::unique('users')->ignore($user->id)],
            'photo' => 'image',
            'permissions' => 'required|min:1'
          ]);
  
          $request_data = $request->except(['permissions','_token','_method','photo']);

          if($request->photo)
          {
              if($user->photo != null)
              {
                  Storage::disk('public_path')->delete('/user_images/'.$user->photo);

                  Image::make($request->photo)->resize(300, 200)->save(public_path('uploads/profile_images/'. $request->photo->hashName()));

                  $request_data['photo'] = $request->photo->hashName();
              }else{

                Image::make($request->photo)->resize(300, 200)->save(public_path('uploads/profile_images/'. $request->photo->hashName()));

                $request_data['photo'] = $request->photo->hashName();
              }
          }
         
         $user->update($request_data);
  
          
  
          $user->syncPermissions($request->permissions);
  
          $msg = ([
              'message' => __('main.updated_successfully'),
              'alert-type' => 'success'
          ]);
          return redirect()->route('dashboard.users.index')->with($msg);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
       echo "hi";
    }

    public function delete(Request $request,$id)
    {
        
        $user_img = User::find($id)->photo;

        if( $user_img != null)
              {
                  Storage::disk('public_path')->delete('/profile_images/'.$user_img);

                 
              }


       User::find($id)->delete();

       $msg = ([
        'message' => __('main.deleted_successfully'),
        'alert-type' => 'success'
    ]);
    return redirect()->route('dashboard.users.index')->with($msg);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function __construct()
    {
       $this->middleware(['permission:clients_read'])->only('index');
       $this->middleware(['permission:clients_create'])->only('store');
       $this->middleware(['permission:clients_update'])->only('edit','update');
       $this->middleware(['permission:clients_delete'])->only('delete');

    }

    
   
    public function index(Request $request)
    {
        $clients = client::when($request->search,function($query) use ($request) {

           return $query->whereTranslationLike('name','%'. $request->search  .'%');
        })->latest()->paginate(5);

        return view ('clients.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('clients.create');
    }

   
    public function store(Request $request)
    {
        $rules = ['phone' =>  'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10'];

        foreach(config('translatable.locales') as $locale)
        {
            $rules += [$locale . '.name' => ['required']];
            $rules += [$locale . '.address' => ['required']];
        }

        $request->validate($rules);

       

        client::create($request->all());
        $msg = ([
            'message' => __('main.added_successfully'),
            'alert-type' => 'success'
        ]);
        return redirect()->route('dashboard.clients.index')->with($msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(client $client)
    {
        //
    }

  
    public function edit(client $client)
    {
        return view ('clients.edit',compact('client'));
    }

   
    public function update(Request $request, client $client)
    {
        $rules = ['phone' =>  'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10'];

        foreach(config('translatable.locales') as $locale)
        {
            $rules += [$locale . '.name' => ['required']];
            $rules += [$locale . '.address' => ['required']];
        }

        $request->validate($rules);

       

        $client->update($request->all());
        $msg = ([
            'message' => __('main.updated_successfully'),
            'alert-type' => 'success'
        ]);
        return redirect()->route('dashboard.clients.index')->with($msg);
    }

    
    public function destroy(client $client)
    {
        //
    }

    public function delete($id)
    {
      client::findOrFail($id)->delete();
      $msg = ([
        'message' => __('main.deleted_successfully'),
        'alert-type' => 'success'
    ]);
    return redirect()->route('dashboard.clients.index')->with($msg);
    }
}

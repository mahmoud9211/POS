<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\category_translation;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;







class CategoryController extends Controller
{

    public function __construct()
    {
       $this->middleware(['permission:categories_read'])->only('index');
       $this->middleware(['permission:categories_create'])->only('store');
       $this->middleware(['permission:categories_update'])->only('edit','update');
       $this->middleware(['permission:categories_delete'])->only('delete');

    }
   
    public function index(Request $request)
    {
        $categories = category::when($request->search,function($query) use ($request){
         
            return $query->whereTranslationLike('name','%'. $request->search .'%');


        })->latest()->paginate(5);

        return view ('categories.index',compact('categories'));
    }

   
    public function create()
    {
        return view ('categories.create');
    }


    public function store(Request $request)
    {
        $rules = [];

        foreach(config('translatable.locales') as $locale)
        {
            $rules += [$locale. '.name' => ['required', Rule::unique('category_translations','name')]];
        }

        $request->validate($rules);

      category::create($request->all());

      $msg = ([
        'message' => __('main.added_successfully'),
        'alert-type' => 'success'
    ]);
    return redirect()->route('dashboard.categories.index')->with($msg);
       
    }

    public function show(category $category)
    {
        //
    }

    
    public function edit(category $category)
    {
        return view ('categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category $category)
    {
        $rules = [];

        foreach(config('translatable.locales') as $locale)
        {
   $rules += [$locale . '.name' => ['required', Rule::unique('category_translations', 'name')->ignore($category->id, 'category_id')]];

        }

        $request->validate($rules);

        $category->update($request->all());

        $msg = ([
            'message' => __('main.updated_successfully'),
            'alert-type' => 'success'
        ]);
        return redirect()->route('dashboard.categories.index')->with($msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        //
    }

    public function delete($id)
    {
        category::findOrFail($id)->delete();

        $msg = ([
            'message' => __('main.deleted_successfully'),
            'alert-type' => 'success'
        ]);
        return redirect()->route('dashboard.categories.index')->with($msg);
    }
}

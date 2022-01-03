<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;


class ProductController extends Controller
{

    public function __construct()
    {
       $this->middleware(['permission:products_read'])->only('index');
       $this->middleware(['permission:products_create'])->only('store');
       $this->middleware(['permission:products_update'])->only('edit','update');
       $this->middleware(['permission:products_delete'])->only('delete');

    }
    
    public function index(Request $request)
    {

        

        $products = product::when($request->search,function($query) use ($request) {
  
            return $query->whereTranslationLike('name','%'. $request->search .'%');     
       })->when($request->category_id,function($q) use($request) {
           return $q->where('category_id',$request->category_id);
       })->latest()->paginate(5);


        $categories = category::get();

        return view ('products.index',compact('products','categories'));
    }

   
    public function create()
    {
        $categories = category::get();
        return view ('products.create',compact('categories'));
    }

   
    public function store(Request $request)
    {
        $rules = ['category_id' => 'required|numeric',
            'purchase_price' => 'required|numeric',
       'selling_price' => 'required|numeric',
     'image' => 'image',
     'stock' => 'required|numeric'];

     foreach (config('translatable.locales') as $locale)
     {
         $rules += [$locale . '.name' =>['required', Rule::unique('product_translations','name')]];
         $rules += [$locale . '.description' =>['required']];

     }

     $request->validate($rules);

     $request_data = $request->all();

     if($request->image)
     {
        Image::make($request->image)->resize(300, 200)->save(public_path('uploads/product_images/'. $request->image->hashName()));

        $request_data['image'] = $request->image->hashName();
     }

     product::create($request_data);

     $msg = ([
        'message' => __('main.added_successfully'),
        'alert-type' => 'success'
    ]);
    return redirect()->route('dashboard.products.index')->with($msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        $categories = category::get();

        return view ('products.edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product)
    {
        $rules = ['category_id' => 'required|numeric',
        'purchase_price' => 'required|numeric',
   'selling_price' => 'required|numeric',
 'image' => 'image',
 'stock' => 'required|numeric'];

 foreach (config('translatable.locales') as $locale)
 {
     $rules += [$locale . '.name' =>['required', Rule::unique('product_translations','name')->ignore($product->id, 'product_id')]];
     $rules += [$locale . '.description' =>['required']];

 }

 $request->validate($rules);

 $request_data = $request->all();

 if($request->image)
 {
   if(!empty($product->image))
   {
     Storage::disk('public_path')->delete('/product_images/'.$product->image);
    Image::make($request->image)->resize(300, 200)->save(public_path('uploads/product_images/'. $request->image->hashName()));

    $request_data['image'] = $request->image->hashName();
   }else{
         
    Image::make($request->image)->resize(300, 200)->save(public_path('uploads/product_images/'. $request->image->hashName()));

    $request_data['image'] = $request->image->hashName();
   }
 }

$product->update($request_data);

 $msg = ([
    'message' => __('main.updated_successfully'),
    'alert-type' => 'success'
]);
return redirect()->route('dashboard.products.index')->with($msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        //
    }

    public function delete($id)
    {
        $image = product::findOrFail($id)->image;

        if($image != null)
        {
            Storage::disk('public_path')->delete('/product_images/'.$image);
 
        }

        product::findOrFail($id)->delete();
        
        $msg = ([
            'message' => __('main.deleted_successfully'),
            'alert-type' => 'success'
        ]);
        return redirect()->route('dashboard.products.index')->with($msg);
    }
}

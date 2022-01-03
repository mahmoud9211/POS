<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\client;
use App\Models\order;
use App\Models\product;

use Illuminate\Http\Request;

class Order_ClientController extends Controller
{

    public function __construct()
    {
       $this->middleware(['permission:orders_read'])->only('index');
       $this->middleware(['permission:orders_create'])->only('store');
       $this->middleware(['permission:orders_update'])->only('edit','update');
       $this->middleware(['permission:orders_delete'])->only('delete');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(client $client)
    {
        $orders = $client->order()->get();
        $categories = category::with('product')->get();
        return view ('orders.create',compact('categories','client','orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,client $client)
    {
        $request->validate([
            'products' => 'required|array',
        ]);

        //$order = $client->order()->create([]);
          $this->attach_order($request, $client);
      

        $msg = ([
            'message' => __('main.added_successfully'),
            'alert-type' => 'success'
        ]);
        return redirect()->route('dashboard.orders.index')->with($msg);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(client $client,order $order)
    { 
        $categories = category::get();
      //  $client = $order->client_id;
        return view ('orders.edit',compact('order','categories','client'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, client $client, order $order)
    {

        $request->validate([
            'products' => 'required|array',
        ]);
        
         $id = $order->id;
        $this->detach_order($id);

        $this->attach_order($request, $client);

        $msg = ([
            'message' => __('main.updated_successfully'),
            'alert-type' => 'success'
        ]);
        return redirect()->route('dashboard.orders.index')->with($msg);




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $order = order::findOrFail($id);

        foreach($order->product as $pro)
        {
            $pro->update([
              'stock' => $pro->stock + $pro->pivot->quantity
            ]);
        }

        $order->delete();

        $msg = ([
            'message' => __('main.deleted_successfully'),
            'alert-type' => 'success'
        ]);
        return redirect()->route('dashboard.orders.index')->with($msg);
    }

    private function attach_order ( $request ,  $client )
    {

        $order= order::create([
            'client_id' => $client->id
       ]);

     


       $order->product()->attach($request->products);

       $total_price = 0;

       foreach($request->products as $id=>$quantity)
       {

           $product = product::findOrFail($id);

          // $total_price += $product->selling_price * $quantity['quantity'];
           $total_price += $product->selling_price * $quantity['quantity'];

           $product->update([
             'stock' => $product->stock - $quantity['quantity']
           ]);
       }

       $order->update([
          'total_price' => $total_price
       ]);

    }


    private function detach_order($id)
    {
        $order = order::findOrFail($id);

        foreach($order->product as $pro)
        {
            $pro->update([
              'stock' => $pro->stock + $pro->pivot->quantity
            ]);
        }

        $order->delete();
    }
}

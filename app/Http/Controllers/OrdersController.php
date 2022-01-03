<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\product;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

    public function __construct()
    {
       $this->middleware(['permission:orders_read'])->only('index');
       $this->middleware(['permission:orders_create'])->only('store');
       $this->middleware(['permission:orders_update'])->only('edit','update');
       $this->middleware(['permission:orders_delete'])->only('delete');

    }

    public function index(Request $request)
    {
$orders = order::whereHas('client',function($query) use($request) {

    return $query->whereTranslationLike('name','%'. $request->search .'%');
})->paginate(5);

return view ('orders.index',compact('orders'));
    }


    public function products ($id)
    {
        $products = order::findOrFail($id)->product()->get();
         
        $order = order::findOrFail($id);

        return view ('orders._products',compact('products','order'));
    }
}

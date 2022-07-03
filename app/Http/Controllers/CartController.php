<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use function Symfony\Component\Routing\Loader\Configurator\collection;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $carts = Cart::with('order.product' ,'customer')->get();

        return  $carts;
    }
    public function index2($customer_id)
    {
        $carts = Cart::with('order.product')->where('customer_id','=',$customer_id)->get();
        return  $carts;
    }
    public function dailyReport(){
        $carts1 = Cart::Join('orders','orders.cart_id','=','carts.id')
            ->join('products','products.id','=','orders.product_id')
            ->join('types','types.id','=','products.type_id')
            ->select('types.name','orders.qtu','carts.created_at')
            ->where('carts.created_at','>',now()->subDay())
            ->orderby('carts.created_at')
            ->get();
        $carts = Cart::where('created_at','>' ,now()->subDay())
            ->get();
        $total = $carts->sum('amount');
        return ['report'=>$carts1,'total'=>$total ];
    }
    public function monthlyReport(){
        $carts1 = Cart::Join('orders','orders.cart_id','=','carts.id')
            ->join('products','products.id','=','orders.product_id')
            ->join('types','types.id','=','products.type_id')
            ->select('types.name','orders.qtu','carts.created_at')
            ->where('carts.created_at','>',now()->subMonth())
            ->get();
        $carts = Cart::where('created_at','>' ,now()->subMonth())
            ->get();
        $total = $carts->sum('amount');
        return ['report'=>$carts1,'total'=>$total ];
    }
    public function random5($customer_id)
    {
          $cart = Cart::Join('orders','orders.cart_id','=','carts.id')
            ->join('products','products.id','=','orders.product_id')
             ->join('types','types.id','=','products.type_id')
             ->select('types.id')
            ->where('carts.customer_id', $customer_id)->get();

             $Collection1 = collect($cart)->countBy('id')->sortDesc();
         $Collection2 = $Collection1->keys()->first();
          $c = $Collection2;
      $product =  Product::with('type')->where('type_id','=',$c)->inRandomOrder()->limit(5)->get();
        return   $product;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}

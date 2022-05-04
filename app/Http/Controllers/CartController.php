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
//        $carts = Cart::with('order')->join('orders','orders.cart_id','=','carts.id')
//            ->join('products','products.id','orders.product_id')
//            ->orderBy('carts.id')
//            ->get();
       //  $carts = Order::with('cart','product')->get();
        $carts = Cart::with('order.product' ,'customer')->get();

        return  $carts;
    }
    public function index2($customer_id)
    {
        $carts = Cart::with('order.product')->where('customer_id','=',$customer_id)->get();
        return  $carts;
    }
    public function random5($customer_id)
    {
//       $product = Type::with('product.order.cart.customer')->where('id','=',$customer_id)->get();
//       $p = collect('$product');
//       return $p;
          $cart = Cart::Join('orders','orders.cart_id','=','carts.id')
            ->join('products','products.id','=','orders.product_id')
             ->join('types','types.id','=','products.type_id')
             ->select('types.id')
            ->where('carts.customer_id', $customer_id)->get();

             $BrandCollection = collect($cart)->countBy('id')->sortDesc();
        return  $BrandCollection->keys();
       // Product::all()->where('id','=','')

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

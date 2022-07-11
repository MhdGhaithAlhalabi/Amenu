<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $carts = Cart::with('order:cart_id,qtu,message,product_id','order.product:id,name' ,'customer:id,name,phone')->where('status','=','waiting')->get();
//     $carts = Cart::join('orders','orders.cart_id','=','carts.id')
//         ->join('products','products.id','=','orders.product_id')
//         ->join('customers','customers.id','=','carts.customer_id')
//         ->where('carts.status','=','waiting')
//         ->select('carts.id','carts.amount','carts.time','carts.status','carts.table_number','orders.qtu','orders.message','products.name','customers.name as customer_name','customers.phone')
//         ->get();
//     $collections = collect($carts)->groupBy('id');

        return $carts ;
    }
    public function cartGoingView()
    {

        $carts = Cart::with('order.product' ,'customer')->where('status','=','going')->get();

        return  $carts;
    }
    public function cartDoneView()
    {
        $carts = Cart::with('order.product' ,'customer')->where('status','=','done')->get();

        return  $carts;
    }
    public function cartGoing($id)
    {
        try {


            $cart = Cart::find($id);
            $cart->status = 'going';
            $cart->save();
        }
    catch (\Exception $e){
        return Response()->json($e->getMessage(),400);
    }

        return Response()->json('cart going', 201);

    }
    public function cartDone($id)
    {
        try {


            $cart = Cart::find($id);
            $cart->status = 'done';
            $cart->save();
        }
        catch (\Exception $e){
            return Response()->json($e->getMessage(),400);
        }
        return Response()->json('cart done', 201);

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
            ->orderby('types.name')
            ->get();

        $carts = Cart::where('created_at','>' ,now()->subMonth())
            ->get();
       $x= collect($carts1)->groupBy(function ($item) {
           return $item->created_at->format('Y-m-d');});
        $xx= collect($carts1)->groupBy('name');
$x2 = collect($x)->sortBy('name');
        $total = $carts->sum('amount');
        return ['report'=>$x2,'r2'=>$xx,'total'=>$total ];
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

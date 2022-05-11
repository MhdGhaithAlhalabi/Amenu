<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\length;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $order = Order::all();
       return $order;
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
        if ($request->hasFile('order')) {
            $order = json_decode(file_get_contents($request->file('order')),true);
            $orderr =  $order['order'];
            $collection = collect($orderr);
            $c_price = 0;
            $c_time =0;
            for($i=0;$i<$collection->count();$i++) {
                $p = $collection[$i]['product_id'];
                $p2 = Product::find($p)->price;
                $t = Product::find($p)->time;
                $q = $collection[$i]['qtu'];
                $c_price = $c_price + $p2 * $q;
                $c_time = $c_time + $t * $q;
            }
            $customer_id = $order['customer_id'];
            $amount = $c_price;
            $time =  $c_time;
            $table_number = $order['table_number'];
            $cart = Cart::create([
                'customer_id' => $customer_id,
                'amount' => $amount,
                'time' => $time,
                'table_number' => $table_number,
                'status' => 'waiting'
            ]);
            $cart_id = DB::table('carts')->select('id')->where('customer_id','=',$customer_id)->orderBy('id','desc')->first()->id;

           for($i=0;$i<$collection->count();$i++){
               $p = $collection[$i]['product_id'];
                $q = $collection[$i]['qtu'];
               $m = $collection[$i]['message'];

               Order::create(
               [
                    'product_id' => $p,
                    'cart_id' => $cart_id,
                   'qtu' => $q,
                   'message'=> $m,
               ]
            );
           }

            return 'cart order created';

        }
        else return 'error';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}

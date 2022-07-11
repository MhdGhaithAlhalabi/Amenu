<?php

namespace App\Http\Controllers;

use App\Events\orderStore;
use App\Models\Cart;
use App\Models\Customer;
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
     * @return \Illuminate\Database\Eloquent\Collection
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
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function testList(Request $request)
    {
        $customerId = $request->customerId;
        $orderList = $request->orderList;
        $order = json_decode($orderList, true);
        return ["orders" => $order, "customerId" => $customerId, "table" => $request->table];
    }


    public function store(Request $request)
    {
        try {
            $points = $request->points;
            $orderList = $request->orderList;
            $order = json_decode($orderList, true);
            $collection = collect($order);
            $c_price = 0;
            $c_time = 0;
            $temp = 0;
            for ($i = 0; $i < $collection->count(); $i++) {
                $product_id = $collection[$i]['id'];
                $price = Product::find($product_id)->price;
                $priceSale = Product::find($product_id)->priceSale;
                $time = Product::find($product_id)->time;
                $qtu = $collection[$i]['qty'];
                if ($points == 0 || $points == NULL) {
                    if ($priceSale == NULL) {
                        $c_price = $c_price + $price * $qtu;
                    } else {
                        $c_price = $c_price + $priceSale * $qtu;
                    }
                } else {
                    if ($priceSale == NULL) {
                        $c_price = $c_price + $price * $qtu;
                        $c_price = $c_price - $points * 5000;
                    } else {
                        $c_price = $c_price + $priceSale * $qtu;
                        $c_price = $c_price - $points * 5000;
                    }

                }
                $c_time = $c_time + $time * $qtu;
            }
            $customer_id = $request->customerId;
            $amount = $c_price;
            $time = $c_time;
            $table_number = $request->table;

            $cart = Cart::create([
                'customer_id' => $customer_id,
                'amount' => $amount,
                'time' => $time,
                'table_number' => $table_number,
                'status' => 'waiting'
            ]);
            $text = 'new order';
            event(new orderStore($text));
            if ($amount > 100000) {
                $customer = Customer::find($customer_id);
                $point = $customer->points + intval($amount / 100000);
                $customer->points = $point;
                $customer->save();
            }
            $cart_id = DB::table('carts')
                ->select('id')
                ->where('customer_id', '=', $customer_id)
                ->orderBy('id', 'desc')
                ->first()->id;

            for ($i = 0; $i < $collection->count(); $i++) {
                $p = $collection[$i]['id'];
                $q = $collection[$i]['qty'];
                // $m = $collection[$i]['message'];

                Order::create(
                    [
                        'product_id' => $p,
                        'cart_id' => $cart_id,
                        'qtu' => $q,
                        'message' => "",
                    ]
                );
            }

            $time_to_eat = Cart::where('status', '=', 'waiting')->avg('time');
           $timee = intval($time_to_eat);
           //$coll = collect($timee);
            if ($timee > 60) {
                return ['gg'=>1,$timee];
            } else {
                return ['gg'=>2,$timee];
            }
        } catch (\Exception $e) {
            return Response()->json($e->getMessage(), 400);
        }

    }
public function teeest(){
    $time_to_eat = Cart::where('status', '=', 'waiting')->avg('time');
    $timee = intval($time_to_eat);

    return $timee;
}
    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}

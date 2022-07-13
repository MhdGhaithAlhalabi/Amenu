<?php

namespace App\Http\Controllers;

use App\Events\orderStore;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Gift;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
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
                if ($priceSale == NULL) {
                    $c_price = $c_price + $price * $qtu;
                } else {
                    $c_price = $c_price + $priceSale * $qtu;
                }

                $c_time = $c_time + $time * $qtu;
            }
            $customer_id = $request->customerId;
            $time = $c_time;
            if ($points == 0) {
                $amount = $c_price;
            }
            $table_number = $request->table;
            if ($points != 0) {
                $amount = $c_price - $points * 5000;
                $customer = Customer::find($customer_id);
                $pp = $customer->points;
                $point = $pp - $points;
                $customer->points = $point;
                $customer->save();
            }
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
                $pp = $customer->points;
                $point = $pp + intval($amount / 100000);
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

            $time_to_eat = Cart::where('status', '=', 'waiting')->sum('time');
            $timee = intval($time_to_eat);
            if ($timee > 30 && $amount > 50000) {
                $gift = Gift::where('active', '=', '1')->first();
                $gift_id = $gift->id;
                $gift_count = $gift->count;
                $gift_to = Gift::find($gift_id);
                $gift_to->update(['count' => $gift_count + 1]);
                return ['gift' => $gift, 'time' => $timee];
            } else {
                return ['gift' => NULL, 'time' => $timee];
            }
        } catch (\Exception $e) {
            return Response()->json($e->getMessage(), 400);
        }

    }

    public function teeest()
    {
//        $time_to_eat = Cart::where('status', '=', 'waiting')->avg('time');
//        $timee = intval($time_to_eat);
//        $gift = Gift::where('active', '=', '1')->first();
//        $gift_id = $gift->id;
//        $gift_count = $gift->count;
//        $gift_to = Gift::find($gift_id);
//        $gift_to->update(['count' => $gift_count + 1]);
//        return ['gift'=>$gift,'time'=> $timee];
        try {
//    $customer = Customer::find(11);
//    $amount= "194500";
//    $pp=$customer->points;
//    $point = $pp + intval($amount / 100000);
//    $customer->points = $point;
//    $customer->save();
//
//               $orders = Order::with('product')
//                ->where('created_at', '>', now()->subMonth())
//                ->get();
//
//            $z = collect($orders);
//             $zz = $z->groupBy(function ($item){
//               return $item->created_at->format('Y-m-d');
//           });
//             $gg = [];
//             foreach ($zz as $z){
//                $gh= collect($z)->groupBy(function ($item){
//                     return $item->product->name;
//                 });
//                     array_push($gg, [
//                         'name' => $z->product->name,
//                         'his' => '',
//                     ]);
//             }
//
//            return $gg;

//                   $zz2 = $z->groupBy(function ($item){
//                return $item->product->name;
//            });
//            $itemsArray = [];
//            foreach ($z as $item){
//                array_push($itemsArray,[
//                    'name' => $item->product->name,
//                ]);
//            }
            //  $itemsArray ;

//            $orders->transform(function ($order) {
//                $itemsArray = [];
//                $order['product'] = $order['product']->groupBy(function ($item){
//                    return $item->product->name;
//                })->map(function ($item) use ($itemsArray) {
//                    array_push($itemsArray, [
//                        'name' => $item[0]['name'],
//                        'qtu' => $item->sum('qtu'),
//                    ]);
//                    return $itemsArray[0];
//                })->values();
//                return $order;
//            });

//
//            $carts1 = Cart::Join('orders', 'orders.cart_id', '=', 'carts.id')
//                ->join('products', 'products.id', '=', 'orders.product_id')
//                ->join('types', 'types.id', '=', 'products.type_id')
//                ->select('types.name', 'orders.qtu', DB::raw("DATE_FORMAT(carts.created_at, '%d-%m-%Y') as date"))//b
//                ->where('carts.created_at', '>', now()->subMonth())
//                ->orderby('types.name')
//                ->get();
//             $carts2 = Cart::Join('orders', 'orders.cart_id', '=', 'carts.id')
//                ->join('products', 'products.id', '=', 'orders.product_id')
//                ->join('types', 'types.id', '=', 'products.type_id')
//                ->select('types.name', 'orders.qtu', DB::raw("DATE_FORMAT(carts.created_at, '%d-%m-%Y') as date"), '')//b
//                ->where('carts.created_at', '>', now()->subMonth())
//                //->orderby('types.name')
//                ->groupby('date', 'types.name', 'orders.qtu')
//                ->get();
            // ->pluck('types.name');
////FORMAT (getdate(), 'd', 'en-US') as date
//            $carts = Cart::where('created_at', '>', now()->subMonth())
//                ->get();
//            $x = collect($carts1)->groupBy('date');
//            $s = $x->values();
//            $ss = $s->toArray();
//            $orders = Order::join('products', 'products.id', '=', 'orders.product_id')
//                ->select('products.name as name', 'orders.qtu as qtu', DB::raw("DATE_FORMAT(orders.created_at, '%d-%m-%Y') as date"))
//               ->where('orders.created_at', '>', now()->subMonth())
//                ->get();
//
//
//
//                $itemsArray = [];
//                $order = $orders->groupby('date','name')->map(function ($item) use ($itemsArray) {
//                    array_push($itemsArray, [
//                        'orders' => $item,
//                        'qtu'=> $item->sum('qtu'),
//                    ]);
//                    return $itemsArray[0];
//                })->values();
//
//          return collect($order);
//


//                $arr=[];
//                foreach ($orders as $order){
//                    array_push($arr,[
//                        'name'=> $order->name,
//                        'qty'=> $order->qtu,
//                        'date'=> $order->date
//                    ]);
//                }
//               return collect($arr)->map();
//               $data = $carts1->selectRaw('sum(qtu) as quantity')
//                ->groupBy('name','date')
//                ->get();
          //  $xx = collect($carts1)->groupBy('name');
       //     $x2 = collect($x)->sortBy('name');
        //    $total = $carts->sum('amount');
         //   return ['report' => $x, 'r2' => $xx, 'total' => $total];








//             $carts = Cart::Join('orders', 'orders.cart_id', '=', 'carts.id')
//                ->join('products', 'products.id', '=', 'orders.product_id')
//                ->join('types', 'types.id', '=', 'products.type_id')
//                ->select(DB::raw("sum(orders.qtu) as sum") , DB::raw("DATE_FORMAT(carts.created_at, '%d-%m-%Y') as date"), '')//b
//                ->where('carts.created_at', '>', now()->subMonth())
//                 ->where('types.name','=','لحم')
//                ->groupby('date', 'sum')
//                ->get();
               $product_id =  Product::all()->pluck('id');
            $purchases = DB::table('orders')
                ->join('products', 'products.id', '=', 'orders.product_id')
             ->select('products.name', DB::raw("DATE_FORMAT(orders.created_at, '%d-%m-%Y') as date"),DB::raw('SUM(orders.qtu) AS sum'))
              ->distinct()
              ->where('orders.created_at', '>', now()->subMonth())
             ->whereIn('products.id',$product_id)
             ->groupBy('orders.created_at','products.name')
             ->get();
//            $purchases2 = DB::table('orders')
//                ->join('products', 'products.id', '=', 'orders.product_id')
//                ->select( DB::raw("DATE_FORMAT(orders.created_at,'%d-%m-%Y') as date"))
//                ->distinct()
//                ->where('orders.created_at', '>', now()->subMonth())
//                ->whereIn('products.id',$product_id)
//                ->groupBy('orders.created_at','products.name')
//                ->get();


                return['report'=> $purchases];





            //->orderby('types.name')













        } catch (\Exception $e) {
            return Response()->json($e->getMessage(), 400);
        }
        return Response()->json('test done', 200);

//        $order= Order::all();
//        return $order;

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

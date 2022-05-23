<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer =  Customer::all();
        return $customer;
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
     * @return array
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'points' => ['nullable', 'integer'],
        ]);

        if ($validator->fails())
        {
            return Response()-> json($validator->getMessageBag(),400);
        }
//        if ($request->points==Null){
//            $request->points = 0;
//        }
        $if_phone_exists =DB::table('customers')->select('id')->where('phone',$request->phone)->exists();
        if (! $if_phone_exists)//if phone not exists register
        {
            $customer = Customer::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'points' => 0,
            ]);
            //$menu = Product::all();
           // $menu =   Menu::with('product.type')->get();
         $menu_product_id = Menu::all()->pluck('product_id')->values();
        $menu =   Product::with('type')
            ->whereIn('id',$menu_product_id)
            ->get();
            $customer_id = Customer::all()->where('phone','=',$request->phone)->first()->id;
            $customer_points = Customer::all()->where('phone','=',$request->phone)->first()->points;
            return ['menu'=>$menu,'customer_id'=>$customer_id,'customer_points'=>$customer_points];
        }
           elseif ($if_phone_exists)//if mac exists
        {
                  //$menu = Product::all();
         //   $menu =   Menu::with('product.type')->get();
         $menu_product_id = Menu::all()->pluck('product_id')->values();
        $menu =   Product::with('type')
            ->whereIn('id',$menu_product_id)
            ->get();
            $customer_id = Customer::all()->where('phone','=',$request->phone)->first()->id;
//                  $customer = Customer::find($customer_id);
//                  $points = $request->points;
//                  $customer->points = $points;
//                  $customer->save();
            $customer_points = Customer::all()->where('phone','=',$request->phone)->first()->points;
            return ['menu'=>$menu,'customer_id'=>$customer_id,'customer_points'=>$customer_points];
           // return ['menu'=>$menu,'customer_id'=>$customer_id];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}

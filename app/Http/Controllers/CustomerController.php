<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
     * @return \Illuminate\Http\Response
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

            return json_encode($validator->getMessageBag());
        }
        if ($request->points==Null){
            $request->points = 0;
        }
        $if_phone_exists =DB::table('customers')->select('id')->where('phone',$request->phone)->exists();
        if (! $if_phone_exists)//if phone not exists register
        {
            $customer = Customer::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'points' => $request->points,
            ]);
              $menu = Product::all();
              $customer_id = Customer::all()->where('phone','=',$request->phone)->first()->id;
              return ['menu'=>$menu,'customer_id'=>$customer_id];
        }
           elseif ($if_phone_exists)//if mac exists
        {

                  $menu = Product::all();
                  $customer_id = Customer::all()->where('phone','=',$request->phone)->first()->id;
                  $customer = Customer::find($customer_id);
                  $points = $request->points;
                  $customer->points = $points;
                  $customer->save();
                  return ['menu'=>$menu,'customer_id'=>$customer_id];
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

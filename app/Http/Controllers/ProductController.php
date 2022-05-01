<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
       //$product = json_encode($product);
      return  $product;

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
            'type_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'details' => ['nullable'],
            'image' => ['nullable'],
            'price' => ['required'],
            'priceSale' => ['nullable'],
            'status' => ['nullable'],
            'time' => ['required'],
        ]);

        if ($validator->fails()) {
            return json_encode($validator->getMessageBag());
        }

        $product = Product::create([
            'type_id' => $request->type_id,
            'name' => $request->name,
            'details' => $request->details,
            'image' => $request->image,
            'price' => $request->price,
            'priceSale' => $request->priceSale,
            'status' => $request->status,
            'time' => $request->time,
        ]);

        return json_encode('product stored');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $product = Product::find($id);
        $validator = Validator::make($request->all(),[
            'type_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'details' => ['nullable'],
            'image' => ['nullable'],
            'price' => ['required'],
            'priceSale' => ['nullable'],
            'status' => ['nullable'],
            'time' => ['required'],
        ]);

        if ($validator->fails()) {
            return json_encode($validator->getMessageBag());
        }

            $type_id =$request->type_id;
            $name =$request->name;
            $details =$request->details;
            $image = $request->image;
            $price = $request->price;
            $priceSale = $request->priceSale;
            $status = $request->status;
            $time = $request->time;
        $product->type_id = $type_id;
        $product->name = $name;
        $product->details =$details;
        $product->image = $image;
        $product->price = $price;
        $product->priceSale = $priceSale;
        $product->status = $status;
        $product->time = $time;
        $product->save();

        return json_encode('product edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}

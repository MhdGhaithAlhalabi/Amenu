<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'image'=>'image|nullable|max:1999',
            'price' => ['required'],
            'priceSale' => ['nullable'],
            'status' => ['nullable'],
            'time' => ['required'],
        ]);

        if ($validator->fails()) {
            return json_encode($validator->getMessageBag());
        }
        // Handle File Upload
        if($request->hasFile('image'))
        {
            // Get filename with the extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public/cover_images', $fileNameToStore);
        }
        else {
            $fileNameToStore = NULL;
        }
        $product = Product::create([
            'type_id' => $request->type_id,
            'name' => $request->name,
            'details' => $request->details,
            'image' => $fileNameToStore,
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
            'image'=>'image|nullable|max:1999',
            'price' => ['required'],
            'priceSale' => ['nullable'],
            'status' => ['nullable'],
            'time' => ['required'],
        ]);
        if ($validator->fails()) {
            return json_encode($validator->getMessageBag());
        }
        // Handle File Upload
        if($request->hasFile('image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = NULL;
        }
            $type_id =$request->type_id;
            $name =$request->name;
            $details =$request->details;
            $price = $request->price;
            $priceSale = $request->priceSale;
            $status = $request->status;
            $time = $request->time;
        $product->type_id = $type_id;
        $product->name = $name;
        $product->details =$details;
        $product->price = $price;
        $product->priceSale = $priceSale;
        $product->status = $status;
        $product->time = $time;
        if($request->hasFile('image')){
            if($product->image != NULL) {
                Storage::delete('public/cover_images/' . $product->image);
                $product->image = $fileNameToStore;
            }
        }
        $product->save();

        return json_encode('product edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if($product->image != NULL){
            // Delete Image
            Storage::delete('public/cover_images/'.$product->image);
        }
        $product->delete();
        return json_encode('Product deleted');
    }
}

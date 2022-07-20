<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use App\Models\Product;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

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
        return $product;

    }

    public function giftView()
    {
        $gift = Gift::all();
        return $gift;

    }

    public function giftStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'image' => 'nullable',
            'active' => ['nullable'],
            'count' => ['nullable'],
        ]);

        if ($validator->fails()) {
            return Response()->json($validator->getMessageBag(), 400);
        }
        $gift = Gift::create([
            'name' => $request->name,
            'image' => $request->image,
            'active' => 0,
            'count' => 0,
        ]);

        return Response()->json('gift stored', 201);

    }

    public function giftActive($id)
    {
        $gifts = Gift::where('active', '!=', '0')->get();
        foreach ($gifts as $gift) {
            $gift->update(['active' => 0]);
        }
        $gift = Gift::find($id);
        $gift->update(['active' => 1]);
        return Response()->json('gift activated', 201);

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'details' => ['nullable'],
            'image' => 'nullable',
            'price' => ['required'],
            'priceSale' => ['nullable'],
            'status' => ['nullable'],
            'time' => ['required'],
        ]);

        if ($validator->fails()) {
            return Response()->json($validator->getMessageBag(), 400);
        }
        // Handle File Upload
//        if($request->hasFile('image'))
//        {
//            // Get filename with the extension
//            $filenameWithExt = $request->file('image')->getClientOriginalName();
//            // Get just filename
//            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
//            // Get just ext
//            $extension = $request->file('image')->getClientOriginalExtension();
//            // Filename to store
//            $fileNameToStore= $filename.'_'.time().'.'.$extension;
//            // Upload Image
//            $path = $request->file('image')->storeAs('public/cover_images', $fileNameToStore);
//        }
//        else {
//            $fileNameToStore = NULL;
//        }
        $product = Product::create([
            'type_id' => $request->type_id,
            'name' => $request->name,
            'details' => $request->details,
            'image' => $request->image,
            'price' => $request->price,
            'priceSale' => $request->priceSale,
            'status' => $request->status,
            'time' => $request->time,
            'rate' => 5,
        ]);

        return Response()->json('product stored', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $validator = Validator::make($request->all(), [
            'type_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'details' => ['nullable'],
            'image' => 'nullable',
            'price' => ['required'],
            'priceSale' => ['nullable'],
            'status' => ['nullable'],
            'time' => ['required'],
        ]);
        if ($validator->fails()) {
            return Response()->json($validator->getMessageBag(), 400);
        }
//        // Handle File Upload
//        if($request->hasFile('image')){
//            // Get filename with the extension
//            $filenameWithExt = $request->file('image')->getClientOriginalName();
//            // Get just filename
//            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
//            // Get just ext
//            $extension = $request->file('image')->getClientOriginalExtension();
//            // Filename to store
//            $fileNameToStore= $filename.'_'.time().'.'.$extension;
//            // Upload Image
//            $path = $request->file('image')->storeAs('public/cover_images', $fileNameToStore);
//        } else {
//            $fileNameToStore = NULL;
//        }
        $type_id = $request->type_id;
        $name = $request->name;
        $details = $request->details;
        $price = $request->price;
        $priceSale = $request->priceSale;
        $status = $request->status;
        $time = $request->time;
        $image = $request->image;
        $product->type_id = $type_id;
        $product->name = $name;
        $product->details = $details;
        $product->price = $price;
        $product->priceSale = $priceSale;
        $product->status = $status;
        $product->time = $time;
        $product->image = $image;
//        if($request->hasFile('image')){
//            if($product->image != NULL) {
//                Storage::delete('public/cover_images/' . $product->image);
//                $product->image = $fileNameToStore;
//            }
//        }
        $product->save();

        return Response()->json('product edited', 201);
    }
    public function giftupdate(Request $request, $id)
    {
        $product = Gift::find($id);
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'image' => 'nullable',

        ]);
        if ($validator->fails()) {
            return Response()->json($validator->getMessageBag(), 400);
        }
//        // Handle File Upload
//        if($request->hasFile('image')){
//            // Get filename with the extension
//            $filenameWithExt = $request->file('image')->getClientOriginalName();
//            // Get just filename
//            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
//            // Get just ext
//            $extension = $request->file('image')->getClientOriginalExtension();
//            // Filename to store
//            $fileNameToStore= $filename.'_'.time().'.'.$extension;
//            // Upload Image
//            $path = $request->file('image')->storeAs('public/cover_images', $fileNameToStore);
//        } else {
//            $fileNameToStore = NULL;
//        }
        $name = $request->name;
        $image = $request->image;
        $product->name = $name;
        $product->image = $image;
//        if($request->hasFile('image')){
//            if($product->image != NULL) {
//                Storage::delete('public/cover_images/' . $product->image);
//                $product->image = $fileNameToStore;
//            }
//        }
        $product->save();

        return Response()->json('gift edited', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $product = Product::find($id);
//        if($product->image != NULL){
//            // Delete Image
//            Storage::delete('public/cover_images/'.$product->image);
//        }
            $product->delete();
        } catch (\Exception $e) {
            return Response()->json($e->getMessage(), 400);
        }
        return Response()->json('product Deleted', 201);

    }

public function giftdestroy($id)
{
    try {
        $product = Gift::find($id);
//        if($product->image != NULL){
//            // Delete Image
//            Storage::delete('public/cover_images/'.$product->image);
//        }
        $product->delete();
    } catch (\Exception $e) {
        return Response()->json($e->getMessage(), 400);
    }
    return Response()->json('Gift Deleted', 201);

}
}

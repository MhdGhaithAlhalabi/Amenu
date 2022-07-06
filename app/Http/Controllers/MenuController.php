<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
     //$menu =   Menu::with('product.type')->get();
        $menu_product_id = Menu::all()->pluck('product_id')->values();
//        $menu1 = Product::Join('menus','menus.product_id','=','products.id')
//            ->join('types','types.id','=','products.type_id')
//            ->select('types.name','products.*','menus.id')
//            ->whereIn('products.id',$menu_product_id)
//            ->get();
        $menu = Product::with('type','menu')
         ->whereIn('id',$menu_product_id)
            ->get();
     return $menu;

    }
    public function outOfMenu()
    {
try{        //product not in menu
         $menu_product_id = Menu::all()->pluck('product_id')->values();
        $product =   Product::with('type')
            ->whereNotIn('id',$menu_product_id)
            ->get();
        }
        catch (\Exception $e){
            return Response()->json($e->getMessage(),400);
        }
        return $product;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'product_id' => ['required'],
        ]);

        if ($validator->fails()) {
            return Response()->json($validator->getMessageBag(),400);
        }

        $menu = Menu::create([
            'product_id' => $request->product_id,
        ]);

        return Response()->json('product stored to menu', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $menu = Menu::find($id);
            $menu->delete();
        }
        catch (\Exception $e){
            return Response()->json($e->getMessage(),400);
        }
        return Response()->json('product Deleted from menu',201);
    }
}

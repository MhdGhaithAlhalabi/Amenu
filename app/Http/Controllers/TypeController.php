<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
         $type =Type::all();
         // $type = json_encode($type);
        return $type;

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
     * @return false|string
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255','unique:types'],
        ]);

        if ($validator->fails()) {
            return json_encode($validator->getMessageBag());
        }

        $product = Type::create([
            'name' => $request->name,
        ]);

        return json_encode('Type stored');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return false|string
     */
    public function update(Request $request, $id)
    {
       $type = Type::find($id);
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255','unique:types'],
        ]);

        if ($validator->fails()) {
            return json_encode($validator->getMessageBag());
        }

             $name = $request->name;
             $type->name = $name;
             $type->save();

        return json_encode('Type edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = Type::find($id);
        $type->delete();
        return json_encode('Type deleted');
    }
}

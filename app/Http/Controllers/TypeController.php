<?php

namespace App\Http\Controllers;

use App\Models\Type;
use http\Client\Response;
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
        $type = Type::with('product')->get();
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
     * @param \Illuminate\Http\Request $request
     * @return false|string
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:types'],
        ]);

        if ($validator->fails()) {
            return Response()->json($validator->getMessageBag(), 400);
        }

        $product = Type::create([
            'name' => $request->name,
        ]);

        return Response()->json('Type stored', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Type $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Type $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Type $type
     * @return false|string
     */
    public function update(Request $request, $id)
    {
        $type = Type::find($id);
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:types'],
        ]);

        if ($validator->fails()) {
            return Response()->json($validator->getMessageBag(), 400);
        }

        $name = $request->name;
        $type->name = $name;
        $type->save();

        return Response()->json('Type edited', 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Type $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $type = Type::find($id);
            $type->delete();
        } catch (\Exception $e) {
            return Response()->json($e->getMessage(), 400);
        }
        return Response()->json('Type Deleted', 201);
    }
}

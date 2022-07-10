<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function index()
    {
        $feedback = Feedback::with('customer')->where('status','=','0')->get();
        return $feedback;
    }
    public function index2()
    {
        $feedback = Feedback::with('customer')->where('status','=','1')->get();
        return $feedback;
    }
    public function feedbackRead($id)
    {
        $feedback = Feedback::find($id);
         $feedback->status=1;
        $feedback->save();
        return Response()->json('feedback reade', 201);
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
     * @return false|\Illuminate\Http\Response|string
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'message' => ['required'],
            'customer_id' => ['required'],
            'points' => ['nullable'],
        ]);

        if ($validator->fails()) {

            return Response()-> json($validator->getMessageBag(),400);
        }

        $product = Feedback::create([
            'message' => $request->message,
            'customer_id' => $request->customer_id,
            'status'=> 0
        ]);

        return Response()->json('feedback send',201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}

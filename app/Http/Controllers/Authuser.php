<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Authuser extends Controller
{
public function registeruser(Request $request){
    $fields = $request->validate([
        'name' => 'required|string',
        'email' => 'required|string|unique:users,email',
        'password' => 'required|string|confirmed'
    ]);
    $user = User::create(
        [
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]
    );
    //$token = $user->createToken('userToken',['user'])->plainTextToken;
    return \response()->json("user created",201);
}
    public function login(Request $request){
        $input = $request->all();
        $validation = validator::make($input,[
                'email' => 'required|string',
                'password' => 'required|string',
                'guard' => 'required'
            ]
        ) ;
        if($validation->fails()){
            return \response()->json(['error'=>$validation->errors()],402);
        }
        if ($input['guard'] == 'apiUser') {
        if (Auth::guard('apiUser')->attempt(['email'=>$input['email'],'password'=>$input['password']])) {

                $user = Auth::guard('apiUser')->user();
                $token = $user->createToken('userToken', ['user'])->plainTextToken;
                return \response()->json(['token:' => $token], 201);
            }
            if (!Auth::guard('apiUser')->attempt(['email'=>$input['email'],'password'=>$input['password']])) {
                return \response()->json(['email or password false'], 402);
            }
            }


            if ($input['guard'] == 'apiAdmin') {
                if (Auth::guard('apiAdmin')->attempt(['email'=>$input['email'],'password'=>$input['password']])) {
                    $admin = Auth::guard('apiAdmin')->user();
                $token = $admin->createToken('adminToken', ['admin'])->plainTextToken;
                    return \response()->json(['token:' => $token], 201);
            }
                if (!Auth::guard('apiAdmin')->attempt(['email'=>$input['email'],'password'=>$input['password']])) {
                    return \response()->json(['email or password false'], 402);
                }
        }
}
    public function destroy(Request $request){
    auth()->user()->tokens()->delete();
        return \response()->json('logout success', 201);
    }


}

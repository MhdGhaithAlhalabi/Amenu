<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Authadmin extends Controller
{
    public function restaurantView()
    {
        $restaurants = Restaurant::select(['name','domain'])->get();
        return $restaurants;
    }
    public function createRestaurant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'domain' => ['required'],
        ]);
        if ($validator->fails()) {
            return Response()->json($validator->getMessageBag(), 400);
        }
        $restaurant = Restaurant::create([
            'name' => $request->name,
            'domain' => $request->domain,
        ]);

        return Response()->json('Restaurant stored', 201);
    }

    public function registeradmin(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);
        $admin = Admin::create(
            [
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => bcrypt($fields['password'])
            ]
        );

        $token = $admin->createToken('adminToken', ['admin'])->plainTextToken;

        return \response()->json(["token" => $token], 201);
    }

    public function usersView()
    {
        $users = User::all();
        return $users;
    }

    public function usersDelete($id)
    {

        try {
            $user = User::find($id);
            $user->delete();
        } catch (\Exception $e) {
            return Response()->json($e->getMessage(), 400);
        }
        return Response()->json('user Deleted', 201);

    }

    public function usersEdit(Request $request, $id)
    {

        $users = User::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return Response()->json($validator->getMessageBag(), 400);
        }
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = bcrypt($request->password);
        $users->save();
        return Response()->json('user edited', 201);
    }
}

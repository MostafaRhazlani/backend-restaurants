<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        return Auth::user();
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Something was wrong'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        return $response = [
            'user' => $user,
            'token' => $token
        ];
    }

    // register
    public function register(Request $request) {

        // validation user
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $defaultRole = null;

        // check if role_type equal Owner
        if ($request->type_role === 'Owner') {
            $defaultRole = Role::where('name_role', 'Owner')->first();

            if(!$defaultRole) {
                return response()->json([
                    'message' => 'Role not found'
                ], 404);
            }

            // create owner
            $user = User::create([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => bcrypt($fields['password']),
                'role_id' => $defaultRole ? $defaultRole->id : null
            ]);

            // validation restauant
            $validation = $request->validate([
                'name_restaurant' => 'required|string',
                'location' => 'required',
                'email' => 'required|email|unique:restaurants,email',
                'phone' => 'required',
            ]);

            // crate restaurant
            $restaurant = Restaurant::create([
                'name_restaurant' => $validation['name_restaurant'],
                'location' => $validation['location'],
                'email' => $validation['email'],
                'phone' => $validation['phone'],
                'user_id' => $user->id
            ]);

            //  return user with restaurant data
            return response()->json([
                'user' => $user,
                'restaurant' => $restaurant,
                'message' => true
            ]);

            // check if role_type equal User
        } else if ($request->type_role === 'User') {
            $defaultRole = Role::where('name_role', 'User')->first();

            if(!$defaultRole) {
                return response()->json([
                    'message' => 'Role not found'
                ], 404);
            }

            $user = User::create([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => bcrypt($fields['password']),
                'role_id' => $defaultRole ? $defaultRole->id : null
            ]);

            // return user data
            return response()->json([
                'user' => $user,
                'message' => 'success'
            ]);
        }

    }

    public function logout() {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}

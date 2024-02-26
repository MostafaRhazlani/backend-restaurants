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
        return Auth::user()->load('restaurant');
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::with('restaurant')->where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'The email or password is incorrect'
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

        $defaultRole = null;

        // check if role_type equal Owner
        if ($request->type_role === 'Owner') {

            $defaultRole = Role::where('name_role', 'Owner')->first();

            if(!$defaultRole) {
                return response()->json([
                    'message' => 'Role not found'
                ], 404);
            }

            // validation owner
            $fieldsOwner = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|confirmed',
                'name_restaurant' => 'required|string',
                'location' => 'required',
                'email_restaurant' => 'required|email|unique:restaurants,email',
                'phone' => 'required',
            ]);

            // create owner
            $owner = User::create([
                'name' => $fieldsOwner['name'],
                'email' => $fieldsOwner['email'],
                'password' => bcrypt($fieldsOwner['password']),
                'role_id' => $defaultRole ? $defaultRole->id : null
            ]);

            // crate restaurant
            $restaurant = Restaurant::create([
                'name_restaurant' => $fieldsOwner['name_restaurant'],
                'location' => $fieldsOwner['location'],
                'email' => $fieldsOwner['email_restaurant'],
                'phone' => $fieldsOwner['phone'],
                'user_id' => $owner->id,
                'description' => $request->description
            ]);

            //  return user with restaurant data
            return response()->json([
                'user' => $owner,
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

            // validation user
            $fieldsUser = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|confirmed',
            ]);

            $user = User::create([
                'name' => $fieldsUser['name'],
                'email' => $fieldsUser['email'],
                'password' => bcrypt($fieldsUser['password']),
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

<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function index() {
        $restaurants = Restaurant::latest()->get();

        return response()->json([
            'data' => $restaurants,
            'message' => 'success'
        ], 201);
    }

    public function store(Request $request) {

        $fileds = $request->validate([
            'name_restaurant' => 'required|string|max:20',
            'email' => 'required|email|unique:restaurants,email',
            'location' => 'required',
            'phone' => 'required|string',
            'description' => 'max:100'
        ]);

        return Restaurant::create([
            'name_restaurant' => $fileds['name_restaurant'],
            'email' => $fileds['email'],
            'location' => $fileds['location'],
            'phone' => $fileds['phone'],
            'description' => $fileds['description'],
            'user_id' => Auth::user()->id,
        ]);
    }

    public function getRestaurant() {
        // return Auth::user();
        return Restaurant::where('user_id', Auth::user()->id)->with('user')->first();
    }
}

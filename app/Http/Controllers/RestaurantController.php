<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index() {
        return Restaurant::all();
    }

    public function store(Request $request) {
        return Restaurant::create($request->all());
    }
}

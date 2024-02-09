<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index($id) {
        $restaurantMenu = Restaurant::with('categories.menus')->find($id);

        return response()->json(['data' => $restaurantMenu, 'message' => 'success'], 200);
    }
}

<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function restaurants() {
        return $this->belongsTo(Restaurant::class);
    }

    public function menus() {
        return $this->hasMany(Menu::class);
    }
}

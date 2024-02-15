<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categories() {
        return $this->hasMany(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'level_id', 'price', 'description', 'image'];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}

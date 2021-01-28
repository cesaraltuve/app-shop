<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    
    // CartDetail N            1 Product
    public function Product()
    {
    	return $this->belongsTo(Product::class);
    }
}

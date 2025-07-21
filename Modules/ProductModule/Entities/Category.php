<?php

namespace Modules\ProductModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;



    protected $fillable = ['name', 'description'];

   
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }
}

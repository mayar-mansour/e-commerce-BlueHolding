<?php

namespace Modules\ProductModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'img_name'];
    public function getImageFullPathAttribute()
    {
        if ($this->attributes['img_name']) {
            if (str_starts_with($this->attributes['img_name'], 'http') == 'true') {
                return $this->attributes['img_name'];
            } else {
                return asset('/uploads/product_images/' . $this->product_id . '/' . $this->attributes['img_name']);
            }
        }
    }
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

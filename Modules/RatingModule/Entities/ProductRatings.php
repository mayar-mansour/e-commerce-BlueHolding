<?php

namespace Modules\RatingModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ProductModule\Entities\Product;
use Modules\UserModule\Entities\User;

class ProductRatings extends Model
{
    use HasFactory;

    // Specify the table if it's not the default plural form of the model name
    protected $table = 'product_ratings';

    // Define the fillable attributes
    protected $fillable = [
        'product_id',
        'user_id',
        'star',
        'comment',
    ];

    /**
     * Define the relationship with the Product model.
     * A ProductRating belongs to a single Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Define the relationship with the User model.
     * A ProductRating belongs to a single User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Factory method for creating new instances.
     */
    protected static function newFactory()
    {
        return \Modules\RatingModule\Database\factories\ProductRatingsFactory::new();
    }
}

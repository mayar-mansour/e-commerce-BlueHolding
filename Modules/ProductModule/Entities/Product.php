<?php

namespace Modules\ProductModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\RatingModule\Entities\ProductRatings;

class Product extends Model
{
    protected $guarded = [];

    /**
     * Scope to filter products based on various parameters.
     */
    public function scopeFilter($query, $request)
    {
        // Filter by name
        if (isset($request['name'])) {
            $query->where('name', 'like', '%' . $request['name'] . '%');
        }

        // Filter by price range
        if (isset($request['price_min']) && isset($request['price_max'])) {
            $query->whereBetween('price', [$request['price_min'], $request['price_max']]);
        } elseif (isset($request['price_min'])) {
            $query->where('price', '>=', $request['price_min']);
        } elseif (isset($request['price_max'])) {
            $query->where('price', '<=', $request['price_max']);
        }

        // Filter by category
        if (isset($request['category'])) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('name', $request['category']);
            });
        }

        // Filter by average_rating with comparison operators
        if (isset($request['average_rating']) && isset($request['rating_operator'])) {
            $allowedOperators = ['<', '<=', '>', '>=', '='];
            $operator = in_array($request['rating_operator'], $allowedOperators) ? $request['rating_operator'] : '=';

            $query->where('average_rating', $operator, $request['average_rating']);
        }

        // Sort by field and direction
        if (isset($request['sort_by'])) {
            $sortField = $request['sort_by'];
            $sortDirection = isset($request['sort_direction']) ? $request['sort_direction'] : 'asc';

            // Validate sort field to prevent SQL injection or invalid column names
            $allowedSortFields = ['name', 'price', 'average_rating']; // Ensure 'average_rating' is in the allowed fields
            if (in_array($sortField, $allowedSortFields)) {
                $query->orderBy($sortField, $sortDirection);
            }
        }

        return $query;
    }


    /**
     * Get the price of the product by ID.
     */
    public function getProductPrice($id)
    {
        return self::find($id)->price;
    }

    /**
     * Scope to filter products by name.
     */
    public function scopeName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    /**
     * Scope to filter products by a price range.
     */
    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    /**
     * Relationship with categories.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    /**
     * Relationship with tags.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Relationship with images.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    /**
     * Relationship with ratings.
     * A product can have many ratings.
     */
    public function ratings()
    {
        return $this->hasMany(ProductRatings::class, 'product_id');
    }

    /**
     * Calculate and update the average rating for the product.
     */
    public function updateAverageRating()
    {
        $averageRating = $this->ratings()->avg('rate');
        $this->update(['average_rating' => $averageRating]);
    }
}

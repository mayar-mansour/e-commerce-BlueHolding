<?php

namespace Modules\RatingModule\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Helpers\ApiResponseHelper;
use Modules\RatingModule\Services\RatingService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Modules\ProductModule\Services\ProductService;
use Modules\ProductModule\Transformers\ProductRatingResource;

class RatingApiController extends Controller
{
    use ApiResponseHelper;
    private $ratingService;
    private $productService;

    public function __construct(RatingService $ratingService, ProductService $productService)
    {
        $this->ratingService = $ratingService;
        $this->productService = $productService;
        
    }

    

    /**
     * Create or update a product rating.
     */
    public function create(Request $request, $product_id)
    {
        $validator = Validator::make($request->all(), [
            'star' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return $this->error(419, $this->reFormatValidationErr($validator->errors()), 'Validation Error');
        }

        // Spam detection
        if ($this->isSpam($request->comment)) {
            return $this->error(403, false, 'Spam detected in your comment', 'Spam detected');
        }

        $user = Auth::guard('api')->user();
        if (!$user) {
            return $this->error(401, false, trans('messages.unauthorized'), trans('messages.unauthorized'));
        }

        // Check if the product exists
        $product = $this->productService->findOne($product_id);
       
        if (!$product) {
            return $this->json(404, false, [], 'Product not found');
        }

        // Create or update the rating
        $data = $request->only(['star', 'comment']);
        $data['product_id'] = $product_id;
        $data['user_id'] = $user->id;

        $productRating = $this->ratingService->createOrUpdateRating($data);

        // Update the average rating in the product
        $this->productService->updateAverageRating($product_id);

        $transformedProduct = ProductRatingResource::make($productRating);
        return $this->json(200, true, $transformedProduct, "Rating Created/Updated");
    }

    /**
     * Get overall rating and comments for a product.
     */
    public function getOverAllRating($product_id)
    {
        $product = $this->productService->findOne($product_id);
        if (!$product) {
            return $this->json(404, false, null, 'No product found');
        }

        $ratingsAndComments = $product->ratings()->select('star', 'comment')->get();

        return $this->json(200, true, $ratingsAndComments, 'Ratings and comments retrieved successfully');
    }

    // Function to detect spam in comments
    private function isSpam($comment)
    {
        $spamKeywords = ['free', '***', 'click here', 'ad', 'buy now'];
        foreach ($spamKeywords as $keyword) {
            if (stripos($comment, $keyword) !== false) {
                return true;
            }
        }

        $words = explode(' ', $comment);
        foreach ($words as $word) {
            if (strlen($word) > 20) {
                return true;
            }
        }

        return false;
    }
}

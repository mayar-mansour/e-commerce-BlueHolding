<?php

namespace Modules\ProductModule\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use App\Helpers\FcmHelper;
use App\Helpers\UploaderHelper;
use App\Helpers\UserValidation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Modules\ProductModule\Entities\Product;
use Modules\ProductModule\Repository\CategoryRepository;
use Modules\ProductModule\Services\ProductService;
use Modules\ProductModule\Transformers\CategoryResource;
use Modules\ProductModule\Transformers\ProductResource;

class ProductApiController extends Controller
{
    use ApiResponseHelper, UploaderHelper;

    private $productService;
    private $categoryRepository;

    public function __construct(ProductService $productService , CategoryRepository $categoryRepository )
    {
        $this->productService = $productService;
        $this->categoryRepository = $categoryRepository;
    }


    public function getProductCategoryDetails($id)
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return $this->error(401, false, 'Unauthenticated', 'User not authenticated');
        }

        $category = $this->categoryRepository->find($id);
        if (is_null($category)) {
            return $this->error(400, false, 'Product not found', 'Product Not Found');
        }


        $categoryResource = CategoryResource::make($category);

        return $this->json(200, true, $categoryResource, 'Success');
    }


    public function getAllProductCategories(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return $this->error(401, false, 'Unauthenticated', 'User not authenticated');
        }

        $categories = $this->categoryRepository->all();
        if (empty($categories)) {
            return $this->error(200, true, 'categories Not Found', 'categories Not Found');
        }
        $transformedCategories = CategoryResource::collection($categories);


        return $this->json(200, true, $transformedCategories, 'Success');
    }
    
    public function getProductDetails($id)
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return $this->error(401, false, 'Unauthenticated', 'User not authenticated');
        }

        $Product = $this->productService->findOne($id);
        if (is_null($Product)) {
            return $this->error(400, false, 'Product not found', 'Product Not Found');
        }


        $ProductResource = ProductResource::make($Product);

        return $this->json(200, true, $ProductResource, 'Success');
    }


    public function getAllProducts(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return $this->error(401, false, 'Unauthenticated', 'User not authenticated');
        }

        $Products = $this->productService->filter($request->all())->paginate(50);

        if (empty($Products)) {
            return $this->error(200, true, 'Products Not Found', 'Products Not Found');
        }
        $transformedProducts = ProductResource::collection($Products);


        return $this->json(200, true, $transformedProducts, 'Success', $transformedProducts->currentPage(), $transformedProducts->lastPage());
    }


    // Create product
    public function createProduct(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return $this->error(401, false, 'Unauthenticated', 'User not authenticated');
        }

        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'stock_quantity' => 'required|integer|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'categories.*' => 'exists:categories,id',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validatedData->errors(),
                'message' => 'Validation Error',
            ], 400);
        }

        $product = $this->productService->create($request->all());
        //created Notification
        // $user_target_tokens = [$user->push_token];
        // $notification_title = "Our Project";
        // $notification_body = "Your product has been Created Successfully";
        // $data = ['product_id' => $product->id];

        // $notification_res = FcmHelper::sendNotification($user_target_tokens, 'all', $notification_title, $notification_body, $data);
         $productResource = ProductResource::make($product);

        return $this->json(201, true, $productResource, 'Product Created Successfully');
    }

    // Update product
    public function updateProduct(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return $this->error(401, false, 'Unauthenticated', 'User not authenticated');
        }

        $validatedData = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'description' => 'nullable|string',
            'stock_quantity' => 'sometimes|integer|min:0', 
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validatedData->errors(),
                'message' => 'Validation Error',
            ], 400);
        }


        $id = $request['id'];
        // Find the product by ID
        $Product = $this->productService->findOne($id);
        if (is_null($Product)) {
            return $this->error(400, false, 'Product not found', 'Product Not Found');
        }

        // Update the product
        $updatedProduct = $this->productService->update($request->all());

        $productResource = ProductResource::make($updatedProduct);

        return $this->json(200, true, $productResource, 'Product Updated Successfully');
    }


    public function deleteProduct($id)
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return $this->error(401, false, 'Unauthenticated', 'User not authenticated');
        }

        // Find the product by ID
        $product = $this->productService->findOne($id);
        if (is_null($product)) {
            return $this->error(400, false, 'Product not found', 'Product Not Found');
        }

        // Delete associated images
        foreach ($product->images as $image) {
            if (!is_null($image->image_path) && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        // Delete associated categories
        $product->categories()->detach();

        // Delete associated tags
        $product->tags()->detach();

        // Delete the product
        $this->productService->delete($id);

        return $this->json(200, true, [], 'Product and its associated data deleted successfully');
    }

    public function searchProduct(Request $request)
    {
        $keyword = $request->input('keyword');
        $items = $request->input('items', 20);

        $results = $this->productService->search($keyword, $items);
        $transformedProducts = ProductResource::collection($results);

        if ($results->count() > 0) {
            return $this->json(200, true, $transformedProducts, 'Success', $transformedProducts->currentPage(), $transformedProducts->lastPage());
        } else {
            // Return an empty array when no Products are found
            return $this->json(200, true, [], 'No Product Found');
        }
    }
}

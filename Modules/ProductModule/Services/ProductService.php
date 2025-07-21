<?php

namespace Modules\ProductModule\Services;

use App\Helpers\UploaderHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\ProductModule\Repository\ProductRepository;
use Illuminate\Support\Facades\Storage;
use Modules\ProductModule\Repository\ProductImageRepository;
use Modules\RatingModule\Services\RatingService;

class ProductService
{
    private $productRepository;
    private $productImageRepository;
    private $ratingService;

    use UploaderHelper;

    public function __construct(ProductRepository $productRepository, ProductImageRepository $productImageRepository, RatingService $ratingService)
    {
        $this->productRepository = $productRepository;
        $this->productImageRepository = $productImageRepository;
        $this->ratingService = $ratingService;
    }

    public function create(array $data)
    {
        $productData = [
            'description' => $data['description'],
            'name' => $data['name'],
            'vendor_id' => Auth::guard('api')->user()->id ?? Auth::guard('web')->user()->id,
            'price' => $data['price'],
            'stock_quantity' => $data['stock_quantity'] ?? 0,

        ];

        // Create the product
        $product = $this->productRepository->create($productData);

        // Convert categories and tags to arrays if they are not already
        if (isset($data['categories'])) {
            $categories = json_decode($data['categories'], true);
            $product->categories()->attach($categories);
        }

        if (isset($data['tags'])) {
            $tags = json_decode($data['tags'], true);
            $product->tags()->sync($tags);
        }



        if (isset($data['images'])) {
            foreach ($data['images'] as $file) {
                $imageName = $this->uploadFile($file, 'product_images/' . $product->id, 'images');
                if ($imageName) {
                    $image_data = [
                        'product_id' => $product->id,
                        'img_name' => $imageName,
                    ];
                    $this->productImageRepository->create($image_data);
                }
            }
        }

        return $product;
    }

    public function update(array $data)
    {
        $productData = [
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock_quantity' => $data['stock_quantity'] ?? 0,
        ];
        $productId = $data['id'];
        $product = $this->productRepository->find($productId);

        if (!$product) {
            return null;
        }

        $this->productRepository->update($productData, $productId);
        // Convert categories and tags to arrays if they are not already
        if (isset($data['categories'])) {
            $categories = json_decode($data['categories'], true);
            $product->categories()->sync($categories); // Use sync instead of attach
        }

        if (isset($data['tags'])) {
            $tags = json_decode($data['tags'], true);
            $product->tags()->sync($tags);
        }


        if (isset($data['images'])) {
            // Delete old images from storage and database
            foreach ($product->images as $image) {
                $filePath = public_path('storage/' . $image->image_path);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
                $image->delete();
            }

            // Upload new images and save them in the database
            foreach ($data['images'] as $file) {
                $imageName = $this->uploadFile($file, 'product_images/' . $product->id, 'images');
                if ($imageName) {
                    $image_data = [
                        'product_id' => $product->id,
                        'img_name' => $imageName,
                    ];
                    $this->productImageRepository->create($image_data);
                }
            }
        }

        return $product;
    }


    public function findAll()
    {
        return $this->productRepository->all();
    }

    public function findOne($id)
    {
        return $this->productRepository->findWhere(['id' => $id])->first();
    }

    public function deleteOne($id)
    {
        $oldData = $this->findOne($id);
        if ($oldData) {
            $this->productRepository->delete($id);
            foreach ($oldData->images as $image) {
                $filePath = public_path('storage/' . $image->image_path);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }
        }
    }

    public function delete($id)
    {
        return $this->productRepository->delete($id);
    }

    public function paginate()
    {
        return $this->productRepository->paginate();
    }

    public function filter($request)
    {
        return $this->productRepository->filter($request);
    }

    public function findWhere(array $arr)
    {
        return $this->productRepository->findWhere($arr);
    }

    public function search($keyword, $items)
    {
        $actions['search_by']['products.name'] = $keyword;
        return $this->productRepository->findAllWithActions($actions, $items);
    }

    public function updateAverageRating($product_id)
    {
        $averageRating = $this->ratingService->calculateAverageRating($product_id);
        $this->productRepository->update(['average_rating' => $averageRating], $product_id);
    }
}

<?php

namespace Modules\ProductModule\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\ProductModule\Entities\Product;
use Modules\ProductModule\Repository\CategoryRepository;
use Modules\ProductModule\Services\ProductService;
use Modules\ProductModule\Transformers\ProductResource;

class ProductAdminController extends Controller
{
    private $productService;
    private $categoryRepository;

    public function __construct(ProductService $productService, CategoryRepository $categoryRepository)
    {
        $this->productService = $productService;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        $products = $this->productService->filter($request->all())->paginate(20);
        return view('productmodule::admin.index', compact('products'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->all();
        return view('productmodule::admin.create', compact('categories'));
    }

    public function store(Request $request)
    {
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
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $this->productService->create($request->all());

        return redirect()->route('products.index')->with('success', 'Product Created Successfully');
    }

    public function edit($id)
    {
        $product = $this->productService->findOne($id);
        $categories = $this->categoryRepository->all();

        if (!$product) {
            return redirect()->route('productmodule::admin.index')->with('error', 'Product Not Found');
        }

        return view('productmodule::admin.edit', compact('product', 'categories'));
    }

    public function update(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'description' => 'nullable|string',
            'stock_quantity' => 'sometimes|integer|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $product = $this->productService->findOne($request->input('id'));
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product Not Found');
        }

        $this->productService->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product Updated Successfully');
    }

    public function destroy($id)
    {
        $product = $this->productService->findOne($id);
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product Not Found');
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

        return redirect()->route('products.index')->with('success', 'Product Deleted Successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends BaseController
{
    
    /**
     * Display a listing of the Products.
     * @return array
     */
    public function index()
    {
        $product = Product::orderBy('id')->simplePaginate(10);
        $data = ProductResource::collection($product);

        return $this->responseSuccess($data, 'Retrieved Products Successfully.', 200);
    }

    /**
     * Create a new Product in DB
     * @param \App\Http\Requests\Product\CreateProductRequest $request
     * @return array
     */
    public function store(CreateProductRequest $request)
    {
        $data = $request->only('name', 'description', 'price');
        $product = Product::create($data);
        
        return $this->responseSuccess(new ProductResource($product), 'Product Created Successfully.', 200);
    }

    /**
     * Find and return Product by id
     * @param string $id
     * @return array
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->responseError(['error' => 'Product Not Found'], 'Product Not Found.', 404);
        }

        return $this->responseSuccess(new ProductResource($product), 'Retrieved Product Successfully.', 200);
    }

    /**
     * Update Specific Product by id
     * @param \App\Http\Requests\Product\UpdateProductRequest $request
     * @param string $id
     * @return array
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->responseError(['error' => 'Product Not Found'], 'Product Not Found.', 404);
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

        return $this->responseSuccess(new ProductResource($product), 'Product Updated Successfully.', 200);
    }

    /**
     * Delete Product by id in DB
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return $this->responseError(['error' => 'Product Not Found'], 'Product Not Found.', 404);
        }
        $product->delete();
        
        return $this->responseSuccess([], 'Product Deleted Successfully.', 200);
    }
}

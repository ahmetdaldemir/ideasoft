<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductRequest;
use App\Repositories\Product\ProductInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;
use App\Http\Resources\ProductResource;

class ProductController extends BaseController
{
    use ApiResponse;

    private ProductInterface $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $product = $this->productRepository->all();
        return $this->success([
            $product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {

        $product = $this->productRepository->create($request);

        return $this->success([
            new ProductResource($product)
        ],'Product Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $Product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->productRepository->find($id);

        if (is_null($product)) {
            return $this->error('Error','404',[
                'Product not found.'
            ]);
        }
        return $this->success([
            new ProductResource($product)
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $Product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = $this->productRepository->update($request, $id);

        return $this->success([
            new ProductResource($product)
        ],'Product Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $Product
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $product = $this->productRepository->delete($id);
        return $this->success([
            new ProductResource($product)
        ],'Product Deleted.');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CategoryRequest;
use App\Repositories\Category\CategoryInterface;
use App\Traits\ApiResponse;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;
use App\Http\Resources\CategoryResource;

class CategoryController extends BaseController
{
    use ApiResponse;

    private CategoryInterface $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $category = $this->categoryRepository->all();
        return $this->success([
            $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->categoryRepository->create($request);
        return $this->success([
            new CategoryResource($category)
        ], 'Category Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->categoryRepository->find($id);

        if (is_null($category)) {
            return $this->error('Error','404',[
                'Product not found.'
            ]);
        }
        return $this->success([
            new CategoryResource($category)
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = $this->categoryRepository->update($request, $id);

        return $this->success([
            new CategoryResource($category)
        ], 'Category Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $category = $this->categoryRepository->delete($id);
        return $this->success([
            new CategoryResource($category)
        ], 'Category Deleted.');
    }
}

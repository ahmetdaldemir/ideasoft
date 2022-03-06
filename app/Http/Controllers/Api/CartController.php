<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Repositories\Category\CartInterface;
use App\Traits\ApiResponse;

class CartController extends BaseController
{
    use ApiResponse;

    private CartInterface $categoryRepository;

    public function __construct(CartInterface $categoryRepository)
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
    public function store(CartRequest $request)
    {
        $category = $this->categoryRepository->create($request);
        return $this->success([
            new CartResource($category)
        ], 'Cart Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Cart $category
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
            new CartResource($category)
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cart $category
     * @return \Illuminate\Http\Response
     */
    public function update(CartRequest $request, $id)
    {
        $category = $this->categoryRepository->update($request, $id);

        return $this->success([
            new CartResource($category)
        ], 'Cart Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Cart $category
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $category = $this->categoryRepository->delete($id);
        return $this->success([
            new CartResource($category)
        ], 'Cart Deleted.');
    }
}

<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\CartRuleRequest;
use App\Http\Resources\CartRuleResource;
use App\Repositories\CartRule\CartRuleInterface;
use App\Traits\ApiResponse;

class CartRuleController extends BaseController
{
    use ApiResponse;

    private CartRuleInterface $cartruleRepository;

    public function __construct(CartRuleInterface $cartruleRepository)
    {
        $this->cartruleRepository = $cartruleRepository;
    }

    public function index()
    {
        $cartrule = $this->cartruleRepository->all();
        return $this->success([
            $cartrule
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartRuleRequest $request)
    {
        $cartrule = $this->cartruleRepository->create($request);
        return $this->success([
            new CartRuleResource($cartrule)
        ], 'CartRule Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\CartRule $cartrule
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cartrule = $this->cartruleRepository->find($id);

        if (is_null($cartrule)) {
            return $this->error('Error','404',[
                'Product not found.'
            ]);
        }
        return $this->success([
            new CartRuleResource($cartrule)
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CartRule $cartrule
     * @return \Illuminate\Http\Response
     */
    public function update(CartRuleRequest $request, $id)
    {
        $cartrule = $this->cartruleRepository->update($request, $id);

        return $this->success([
            new CartRuleResource($cartrule)
        ], 'CartRule Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\CartRule $cartrule
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $cartrule = $this->cartruleRepository->delete($id);
        return $this->success([
            new CartRuleResource($cartrule)
        ], 'CartRule Deleted.');
    }
}

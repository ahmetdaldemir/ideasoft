<?php namespace App\Http\Controllers\Api;

use App\Repositories\OrderDiscount\OrderDiscountInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
 use Validator;
use App\Http\Resources\OrderDiscountResource;


class OrderDiscountController extends BaseController
{
    use ApiResponse;

    private OrderDiscountInterface $orderDiscountRepository;

    public function __construct(OrderDiscountInterface $orderDiscountRepository)
    {
        $this->orderDiscountRepository = $orderDiscountRepository;
    }

    public function index()
    {
        $order = $this->orderDiscountRepository->all();
        return $this->success([
            $order
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orderId' => 'required|integer',
            'discounts.*.discountReason' =>  'required',
            'discounts.*.discountAmount' => 'required|regex:/^\d{1,13}(\.\d{1,4})?$/',
            'discounts.*.subtotal' => 'required|regex:/^\d{1,13}(\.\d{1,4})?$/',
            'totalDiscount' => 'required|regex:/^\d{1,13}(\.\d{1,4})?$/',
            'discountedTotal' => 'required|regex:/^\d{1,13}(\.\d{1,4})?$/',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $order = $this->orderDiscountRepository->create($request);

        if ($this->orderDiscountRepository->hasErrors()) {
            return $this->error([
                $this->orderDiscountRepository->getErrors()
            ], 'Order Not Created');
        }

        return $this->success([
            new OrderDiscountResource($order)
        ], 'Order Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $Order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->orderDiscountRepository->find($id);

        if (is_null($order)) {
            return $this->sendError('Order not found.');
        }
        return $this->success([
            new OrderDiscountResource($order)
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $Order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'orderId' => 'required|integer',
            'discounts.*.discountReason' =>  'required',
            'discounts.*.discountAmount' => 'required|regex:/^\d{1,13}(\.\d{1,4})?$/',
            'discounts.*.subtotal' => 'required|regex:/^\d{1,13}(\.\d{1,4})?$/',
            'totalDiscount' => 'required|regex:/^\d{1,13}(\.\d{1,4})?$/',
            'discountedTotal' => 'required|regex:/^\d{1,13}(\.\d{1,4})?$/',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $order = $this->orderDiscountRepository->update($request);

        if ($this->orderDiscountRepository->hasErrors()) {
            return $this->error([
                $this->orderDiscountRepository->getErrors()
            ], 'Order Not Created');
        }

        return $this->success([
            new OrderDiscountResource($order)
        ], 'Order Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $Order
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $order = $this->orderDiscountRepository->delete($id);
        return $this->success([
            new OrderDiscountResource($order)
        ], 'Order Deleted.');
    }
}

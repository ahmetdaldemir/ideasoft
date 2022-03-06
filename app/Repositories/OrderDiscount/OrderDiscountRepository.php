<?php


namespace App\Repositories\OrderDiscount;


use App\Abstracts\OrderRequest;
use App\Models\Order;
use App\Models\OrderDiscount;
use App\Traits\HasErrors;

class OrderDiscountRepository extends OrderRequest implements OrderDiscountInterface
{
    use HasErrors;

    protected $model;

    public function __construct(OrderDiscount $orderdiscount)
    {
        $this->model = $orderdiscount;
    }


    public function all()
    {
        $orderdiscounts = $this->model->all();
        return $orderdiscounts;
    }

    public function create(object $data)
    {
        $this->model->orderId = $data->orderId;
        $this->model->totalDiscount = $data->totalDiscount;
        $this->model->discountedTotal = $data->discountedTotal;
        $this->model->discounts = json_encode($data->discounts);
        $this->model->save();
    }

    public function update(object $data, $id)
    {
        $order = $this->model->find($id);
        $order->orderId = $data->orderId;
        $order->totalDiscount = $data->totalDiscount;
        $order->discountedTotal = $data->discountedTotal;
        $order->discounts = json_encode($data->discounts);
        $order->save();
    }

    public function delete($id)
    {
        $orderdiscount = $this->model->find($id);
        $orderdiscount->delete();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }
}

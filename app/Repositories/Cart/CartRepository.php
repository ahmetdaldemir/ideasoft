<?php


namespace App\Repositories\Cart;


use App\Abstracts\OrderRequest;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\Service\Uuid;

class CartRepository implements CartInterface
{

    protected $product;
    protected $model;
    protected $uuid;
    protected $orderRequest;

    public function __construct(Cart $cart, Uuid $uuid, Product $product, CartProduct $cartproduct, OrderRequest $orderRequest)
    {
        $this->model = $cart;
        $this->product = $product;
        $this->cartproduct = $cartproduct;
        $this->orderRequest = $orderRequest;
        $this->uuid = $uuid->getUuid();
    }


    public function all()
    {
        $cart = $this->model->all();
        return $cart;
    }

    public function create(object $data)
    {
        $this->model->cart_id = $this->uuid;
        $this->model->save();

        $price = Product::find($data->product_id)->price;
        $cartproduct = $this->cartproduct->find($data->product_id);
        if ($cartproduct) {
            $this->orderRequest->stockControl((array)$data);
            if ($this->orderRequest->hasErrors()) {
                return $this->orderRequest->getErrors();
            }
            $cartproduct->qty += $data->qty;
            $cartproduct->price = $price;
            $cartproduct->save();
        } else {
            $this->cartproduct->cartid = $this->uuid;
            $this->cartproduct->qty = $this->qty;
            $this->cartproduct->price = $price;
            $this->cartproduct->save();
        }
        $this->model->isDiscount();
        return $this->model;
    }

    public function update(object $data, $id)
    {
        //
    }

    public function delete($id)
    {
        $cart = $this->model->find($id);
        $cart->delete();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }
}

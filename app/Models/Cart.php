<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $producttotal;

    public function __construct()
    {
        $this->producttotal = 0;
    }

    public function product()
    {
        return $this->belongsTo(CartProduct::class, 'cart_id', 'id');
    }

    public function isDiscount()
    {
        $cart_id = $this->cart_id;
        $products = $this->product();
        foreach ($products as $product) {
            $this->producttotal += $product->qty * $product->price;
            $productdiscount[] = $this->getProduct($product);
        }

        $totaldiscount = $this->getTotalDiscount($this->producttotal);
    }

    public function getTotalDiscount($producttotal)
    {
        $cartrule = CartRule::whereNot('minimum_amount')->where('minimum_amount' < $producttotal)->where('is_active', TRUE)->first();
        if ($cartrule) {
            return $cartrule;
        }

    }

    public function getProduct($product)
    {
        $cartrule = CartRuleProduct::where('product_id', $product->product_id)->first();
        if ($cartrule) {
            return $cartrule;
        }
    }

    public function getCategory($product)
    {
        $category = Product::find($product->product_id);
        $cartrule = CartRuleProduct::where('category_id', $category->category_id)->first();
        if ($cartrule) {
            return $cartrule;
        }
    }
}

<?php


namespace App\Abstracts;


use App\Models\Product;
use App\Repositories\Product\ProductInterface;
use App\Service\Translator;
use App\Traits\HasErrors;

abstract class OrderRequest
{
    use HasErrors;


    protected $productRepository;
    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function stockControl($items):void
    {
      foreach($items as $product)
      {
           $model =  Product::find($product['productId']);
           if(empty($model) || $model->stock < $product['quantity'])
           {
               $this->addError(Translator::STOCK_AVAILABILITY);
               continue;
           }
      }
    }

    public function priceControl($items,$total):void
    {
        $totalPrice = 0;
        foreach($items as $product)
        {
            $model = Product::find($product['productId']);
            if(empty($model) || $model['price'] != $product->unitPrice)
            {
                $this->addErrors(['error' => Translator::STOCK_AVAILABILITY]);
                continue;
            }

            $totalPrice += $product->unitPrice;
            if($totalPrice != $total)
            {
                $this->addErrors(['error' => Translator::TOTAL_PRICE_ARE_NOT_EQUAL]);
                continue;
            }
        }
    }

}

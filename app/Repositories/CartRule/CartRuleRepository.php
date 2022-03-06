<?php


namespace App\Repositories\CartRule;


use App\Models\Cart;
use App\Models\CartRule;
use App\Models\CartRuleCategory;
use App\Models\CartRuleProduct;
use App\Repositories\Category\CartInterface;
use Illuminate\Support\Str;

class CartRuleRepository implements CartRuleInterface
{

    protected $model;
    protected $cartrule_category_model;
    protected $cartrule_product_model;

    public function __construct(CartRule $cartrule,CartRuleCategory $cartrule_category_model,CartRuleProduct $cartrule_product_model)
    {
        $this->model = $cartrule;
        $this->cartrule_category_model = $cartrule_category_model;
        $this->cartrule_product_model = $cartrule_product_model;
    }


    public function all()
    {
        $cartrule = $this->model->all();
        return $cartrule;
    }

    public function create(object $data)
    {
        $this->model->name = $data->name;
        $this->model->code = Str::slug($data->name,"_");
        $this->model->qty = $data->qty;
        $this->model->minimum_amount = $data->minimum_amount;
        $this->model->minimum_amount_type = $data->minimum_amount_type;
        $this->model->minimum_amount_discount = $data->minimum_amount_discount;
        $this->model->gift_product = $data->gift_product;
        $this->model->gift_product_qty = $data->gift_product_qty;
        $this->model->customer_id = $data->customer_id;
        $this->model->save();
        $id = $this->model->id;

        if(!empty($data->category_id))
        {
            $this->cartrule_category_model->cartrule_id = $id;
            $this->cartrule_category_model->category_id = $data->category_id;
            $this->cartrule_category_model->save();
        }

        if(!empty($data->product_id))
        {
            $this->cartrule_product_model->cartrule_id = $id;
            $this->cartrule_product_model->product_id = $data->product_id;
            $this->cartrule_product_model->save();
        }

        return $this->model;
    }

    public function update(object $data, $id)
    {
        $cartrule = $this->model->find($id);
        $cartrule->name = $data->name;
        $cartrule->code = Str::slug($data->name,"_");
        $cartrule->qty = $data->qty;
        $cartrule->minimum_amount = $data->minimum_amount;
        $cartrule->minimum_amount_type = $data->minimum_amount_type;
        $cartrule->minimum_amount_discount = $data->minimum_amount_discount;
        $cartrule->gift_product = $data->gift_product;
        $cartrule->gift_product_qty = $data->gift_product_qty;
        $cartrule->customer_id = $data->customer_id;
        $cartrule->save();

        if(!empty($data->category_id))
        {
            $this->cartrule_category_model->where('cartrule_id',$id)->delete();
            $this->cartrule_category_model->cartrule_id = $id;
            $this->cartrule_category_model->category_id = $data->category_id;
            $this->cartrule_category_model->save();
        }

        if(!empty($data->product_id))
        {
            $this->cartrule_product_model->where('cartrule_id',$id)->delete();
            $this->cartrule_product_model->cartrule_id = $id;
            $this->cartrule_product_model->product_id = $data->product_id;
            $this->cartrule_product_model->save();
        }

        return $this->model;
    }

    public function delete($id)
    {
        $cartrule = $this->model->find($id);
        $cartrule->delete();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }
}

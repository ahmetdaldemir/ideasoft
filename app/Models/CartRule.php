<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartRule extends Model
{
    use HasFactory;


    public function product()
    {
        return  $this->belongsTo(CartRuleProduct::class,'cartrule_id','id');
    }
    public function category()
    {
        return  $this->belongsTo(CartRuleCategory::class,'cartrule_id','id');
    }


}

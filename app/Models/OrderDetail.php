<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_details';
    protected $guarded = [];

    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function getSubTotalAttribute(){
        return $this->price * $this->qty;
    }

    public function getTaxPriceAttribute(){
        $total = $this->sub_total * $this->tax/100;
        return round($total,2);
    }
}

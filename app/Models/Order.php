<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $guarded = [];


    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function distributor(){
        return $this->belongsTo(Distributor::class,'distributor_id');
    }

    public function details(){
        return $this->hasMany(OrderDetail::class,'order_id');
    }

    public function getOrderSubTotalAttribute(){
        $sum = 0;
        if (isset($this->details) && count($this->details) > 0)
        {
            foreach ($this->details as $item)
                $sum+=$item->sub_total;
        }
        return $sum;
    }

    public function getSumCostPriceAttribute(){
        $sum = 0;
        if (isset($this->details) && count($this->details) > 0)
        {
            foreach ($this->details as $item)
                $sum+=$item->product->cost_price;
        }
        return $sum;
    }

    public function getSumProfitAttribute(){

        $sum = $this->sub_total - $this->sum_cost_price;
        return (float)$sum;
    }
    public function getTotalTaxAttribute(){
        $sum = 0;
        if (isset($this->details) && count($this->details) > 0)
        {
            foreach ($this->details as $item)
                $sum+=$item->tax_price;
        }
        return round($sum,2);
    }
    public function getTotalAttribute(){

        $total = $this->order_sub_total + $this->total_tax;
        return (float)$total;
    }

    public function getStatusNameAttribute(){
        switch ($this->status_id){
            case 1:
                return __('msg.pending');
            case 2:
                return __('msg.approve');
            case 3:
                return __('msg.cancel');
        }
    }

    public function status_name_api($lang){
        switch ($this->status_id){
            case 1:
                return __('msg.pending',[],$lang);
            case 2:
                return __('msg.approve',[],$lang);
            case 3:
                return __('msg.cancel',[],$lang);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleOrder extends Model
{
    use HasFactory;
    protected $primaryKey = 'saleOrderID';
    protected $table = 'saleOrders';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'productID', 'productID');
    }
}

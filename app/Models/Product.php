<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'productID';
    protected $table = 'products';
    protected $guarded = [];

    public function brand()
    {
        return $this->belongsTo(\App\Models\Brand::class, 'brandID', 'brandID');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'categoryID', 'categoryID');
    }

    public function purchaseOrders()
    {
        return $this->hasMany(\App\Models\PurchaseOrder::class, 'productID', 'productID');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDelivered extends Model
{
    use HasFactory;
    protected $primaryKey = 'saleDeliveredID';
    protected $table = 'saleDelivered';
    protected $guarded = [];
    public $timestamps = false;


}

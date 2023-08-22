<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturnDetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'saleReturnDetailID';
    protected $table = 'saleReturnDetails';
    protected $guarded = [];
    public $timestamps = false;
}

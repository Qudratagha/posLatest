<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;
    protected $primaryKey = 'purchaseReturnID';
    protected $table = 'purchaseReturns';
    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(\App\Models\Account::class, 'accountID', 'accountID');
    }

    public function purchase()
    {
        return $this->belongsTo(\App\Models\Purchase::class, 'purchaseID', 'purchaseID');
    }

    public function purchaseReturnDetails()
    {
        return $this->hasMany(\App\Models\PurchaseReturnDetail::class, 'purchaseReturnID', 'purchaseReturnID');
    }




}

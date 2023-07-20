<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTransfer extends Model
{
    use HasFactory;
    protected $primaryKey = 'accountTransferID';
    protected $table = 'accountTransfers';
    protected $guarded = [];

    public function accountFrom()
    {
        return $this->belongsTo(\App\Models\Account::class, 'accountID', 'fromAccountID');
    }

    public function accountTo()
    {
        return $this->belongsTo(\App\Models\Account::class, 'accountID', 'toAccountID');
    }
}

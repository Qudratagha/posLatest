<?php

use App\Models\Reference;
use App\Models\Transaction;

function getRef(){
    $ref = Reference::first();
    if($ref){
        $ref->ref = $ref->ref + 1;
    }
    else{
        $ref = new Reference();
        $ref->ref = 1;
    }
    $ref->save();
    return $ref->ref;
}


function addTransaction($accountID, $date, $type, $credit, $debt, $refID, $desc){
    Transaction::create([
        'accountID' => $accountID,
        'date' => $date,
        'type' => $type,
        'credit' => $credit,
        'debt' => $debt,
        'refID' => $refID,
        'description' => $desc
    ]);
}

function getAccountBalance($id)
{
    $cr = Transaction::where('accountID', $id)->sum('credit');
    $db = Transaction::where('accountID', $id)->sum('debt');
    
    return $cr - $db;
}
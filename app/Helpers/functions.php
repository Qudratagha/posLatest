<?php

use App\Models\Reference;

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

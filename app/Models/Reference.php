<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;
    protected $primaryKey = 'refID';
    protected $table = 'references';
    protected $guarded = [];
    public $timestamps = false;
}

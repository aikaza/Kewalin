<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{

	protected $fillable = ['code','prefix','number'];
    public $table = 'codes';
    public $timestamps = false;
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Returning extends Model
{
	public $table = "returns";
    protected $fillable = ['order_id','returned_qtyp','detail'];
}

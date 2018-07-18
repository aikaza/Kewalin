<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockPColorDetail extends Model
{

	protected $fillable = ['color_code','qtyp','stock_id'];
    public $table = 'stock_pcolor_details';
}

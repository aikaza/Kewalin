<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
    	'lot_number','product_id','qtyp','unit_id','created_by'
    ];


    public function product(){
    	return $this->belongsTo('App\Product');
    }

    public function colors(){
    	return $this->hasMany('App\StockPColorDetail');
    }

    


}

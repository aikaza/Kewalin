<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $fillable = [
    	'product_id','lot_number','no_rolls','no_yards','cost_per_unit',
    	'total_cost'
    ];

    public function user(){
    	return $this->belongsTo('App\User','created_by');
    }

    public function product(){
    	return $this->belongsTo('App\Product');
    }

    public function unit(){
        return $this->belongsTo('App\Unit');
    }
}

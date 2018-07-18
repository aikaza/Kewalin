<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
	protected $fillable = [
		'product_id','lot_number','qtyp','qtyy','qtym','qtykg','unit_id',
		'detail','price_per_unit','total_income','customer_id','order_id',
		'created_by','updated_by','code_id'
	];

	public $timestamps = false;
	
	public function user(){
		return $this->belongsTo('App\User','created_by');
	}

	public function product(){
		return $this->belongsTo('App\Product');
	}

	public function customer(){
		return $this->belongsTo('App\Customer');
	}

	public function order(){
		return $this->belongsTo('App\Order');
	}

	public function unit(){
		return $this->belongsTo('App\Unit');
	}

    public function code(){
        return $this->belongsTo('App\Code');
    }
}

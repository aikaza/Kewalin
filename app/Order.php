<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    	'customer_id','product_id','qtyp','refcode','status',
    	'created_by','updated_by','code','code_prefix','code_number'
    ];

    public $timestamps = false;

    protected $updated_at = '';



    public function product(){
    	return $this->belongsTo('App\Product');
    }

    public function customer(){
    	return $this->belongsTo('App\Customer');
    }

    public function userCreate(){
    	return $this->belongsTo('App\User','created_by');
    }

    public function userUpdate(){
    	return $this->belongsTo('App\User','updated_by');
    }

    public function code(){
        return $this->belongsTo('App\Code');
    }
}

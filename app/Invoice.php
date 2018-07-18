<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
    	'export_id','customer_id','total','status','created_at','updated_at'
    ];

    public function customer(){
    	return $this->belongsTo('App\Customer');
    }

    public function export(){
    	return $this->belongsTo('App\Export');
    }
}

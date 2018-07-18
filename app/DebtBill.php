<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DebtBill extends Model
{
    public $table = 'debtbills';

    public function code(){
    	return $this->belongsTo('App\Code');
    }

    public function customer(){
    	return $this->belongsTo('App\Customer');
    }

    public function transaction(){
    	return $this->hasOne('App\Transaction','debtbill_id');
    }
}

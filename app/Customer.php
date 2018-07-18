<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
    	'first_name','last_name','alias_name','email','phone_no','address',
    	'created_at','updated_at'
    ];

    protected $hidden = ['created_at','updated_at'];

    public function orders(){
    	return $this->hasMany('App\Order');
    }

}

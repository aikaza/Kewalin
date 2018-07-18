<?php 

function make($controller, $method, $as = null){
	$as = (is_null($as)) ? $method : $as;
	return [
		'uses' => $controller.'Controller@'.$method,
		'as' => $as
	];

}

function __customer__($method, $as = null){
	return make('Customer', $method, $as);
}

function __unit__($method, $as = null){
	return make('Unit', $method, $as);
}

function __stock__($method, $as = null){
	return make('Stock', $method, $as);
}

function __export__($method, $as = null){
	return make('Export', $method, $as);
}

function __config__($method, $as = null){
	return make('Configuration', $method, $as);
}

function __report__($method, $as = null){
	return make('Report', $method, $as);
}

function __product__($method, $as = null){
	return make('Product', $method, $as);
}

function __order__($method, $as = null){
	return make('Order', $method, $as);
}

function __user__($method, $as = null){
	return make('User', $method, $as);
}

function __invoice__($method, $as = null){
	return make('Invoice', $method, $as);
}

function __dt__($method, $as = null){
	return make('API\Datatable', $method, $as);
}
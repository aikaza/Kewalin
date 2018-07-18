<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuration;
class ConfigurationController extends Controller
{

	
	public function update(Request $rq){
		return dbAction(function() use ($rq){
			$config = $rq->config;
			foreach ($config as $key => $value) {
				$conf = \App\Configuration::where('key',$key)->first();
				$conf->value = $value;
				$conf->save();
			}
			return redirect()->back();
		}, 'อัพเดทการตั้งค่าแล้ว');
	}


}

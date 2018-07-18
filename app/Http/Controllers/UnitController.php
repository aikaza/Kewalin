<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUnit;
class UnitController extends Controller
{


	public function index()
	{
		$units = \App\Unit::all();
		$tosend = [ 'units'	=> $units ];
		return view('unit.index',$tosend);
	}




	public function store(StoreUnit $rq)
	{
		return dbAction(function() use($rq){
			extract($rq->all());
			$unit = new \App\Unit;
			$unit->prefix = $prefix;
			$unit->name = $name;
			$unit->name_eng = $name_eng;
			$unit->save();
			return redirect()->route('units.index');
		},'เพิ่มหน่วยเรียบร้อยแล้ว');
	}




	public function update(StoreUnit $rq)
	{
		return dbAction(function() use($rq){
			extract($rq->all());
			$unit = \App\Unit::find($id);
			$unit->prefix = $prefix;
			$unit->name = $name;
			$unit->name_eng = $name_eng;
			$unit->save();
			return redirect()->route('units.index');
		},'แก้ไขเรียบร้อยแล้ว');
	}
}

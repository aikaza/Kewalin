<?php 

namespace App\Classes;

class CodeGenerator{

	protected $prefix;
	protected $length;
	protected $result;


	public function __construct($prefix,$length){
		$this->prefix = $prefix;
		$this->length = $length;
	}

	public function make(){
		$cg = new \App\Code;
		$cg->prefix = $this->prefix;
		$cg->number = $this->getNumber();
		$cg->code = $this->getWithoutGenerate();
		$cg->save();
		$this->result = $cg;
		return $cg;
	}

	public function getId(){
		return $this->result->id;
	}


	public function getWithoutGenerate(){
		$number = sprintf('%0'.$this->length.'d', $this->getNumber());
		return $this->prefix.$number;
	}

	protected function getNumber(){
		$number = \App\Code::where('prefix',$this->prefix)->max('number');
		$number = (is_null($number)) ? 0 : $number;
		return $number + 1;
	}



}
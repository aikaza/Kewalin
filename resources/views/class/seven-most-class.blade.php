@php

class SevenMost{

	public static function getRankColor($rank){
		$color;
		switch($rank){
			case 1: $color = 'red';
			break;
			case 2: $color = 'blue';
			break;
			case 3: $color = 'green';
			break;
			default: $color = 'grey';
			break;
		}
		return $color;
	}

}

@endphp
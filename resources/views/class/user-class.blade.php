@php

class User{

	public static function getRole($abbv){
		$role;
		switch ($abbv) {
			case 'rsb':
			$role = 'ฝ่ายจัดซื้อ';
			break;
			case 'acm':
			$role = 'ฝ่ายบัญชี';	
			break;
			case 'ext_minor':
			$role = 'ฝ่ายส่งสินค้า (โกดัง)';
			break;
			case 'ext_major':
			$role = 'ฝ่ายส่งสินค้า';
			break;
			default:
			$role = 'แอดมิน';
			break;
		}
		return $role;
	}



}

@endphp
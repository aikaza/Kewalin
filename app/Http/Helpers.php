<?php

function appconfig($key)
{
    $config = \DB::table('configurations')->where('key', $key)->first();
    return $config->value;
}

function sum($collection, $key)
{
    $sum = 0;
    foreach ($collection as $col) {
        $sum += $col->$key;
    }
    return $sum;
}

function pStatus($remain)
{
    $text  = null;
    $class = null;
    switch (true) {
        case ($remain > appconfig('cripoint')):
            $text  = 'ปกติ';
            $class = 'text-primary';
            break;
        case ($remain > 0 && $remain <= appconfig('cripoint')):
            $text  = 'สินค้าใกล้หมด';
            $class = 'text-danger';
            break;
        default:
            $text  = 'สินค้าหมด';
            $class = 'text-danger';
            break;
    }
    return ['text' => $text, 'class' => $class];
}

function cInfo($id)
{
    $c = \App\Customer::find($id);
    return $c;
}

function pInfo($id)
{
    $p = \App\Product::find($id);
    return $p;
}

function unitName($id)
{
    if (App::isLocale('th')) {
        return \App\Unit::find($id)->name;
    } else {
        return \App\Unit::find($id)->name_eng;
    }
}

function lotArray($lot_text)
{
    return explode(',', $lot_text);
}

function checkProductColor($value)
{
    return ($value === null) ? "*" : $value;
}

function units()
{
    return \App\Unit::all();
}

function millionFormat($number, $default = null)
{
    if ($default !== null) {
        if ($number <= $default) {
            return number_format($number);
        }
    }
    $number = $number / 1000000;
    $number = number_format($number, 2) + 0;
    return $number . 'M';
}

function premainCount($id)
{
    $p = \App\Stock::select(\DB::raw('SUM(qtyp) as remain'))
        ->where('product_id', $id)
        ->groupBy('product_id')
        ->first();
    return ($p === null) ? 0 : $p->remain;
}

function MoneyNumberToWords($amount_number)
{
    $amount_number = number_format($amount_number, 2, ".", "");
    $pt            = strpos($amount_number, ".");
    $number        = $fraction        = "";
    if ($pt === false) {
        $number = $amount_number;
    } else {
        $number   = substr($amount_number, 0, $pt);
        $fraction = substr($amount_number, $pt + 1);
    }

    $ret  = "";
    $baht = ReadNumber($number);
    if ($baht != "") {
        $ret .= $baht . "บาท";
    }

    $satang = ReadNumber($fraction);
    if ($satang != "") {
        $ret .= $satang . "สตางค์";
    } else {
        $ret .= "ถ้วน";
    }

    return $ret;
}

function ReadNumber($number)
{
    $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
    $number_call   = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
    $number        = $number + 0;
    $ret           = "";
    if ($number == 0) {
        return $ret;
    }

    if ($number > 1000000) {
        $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
        $number = intval(fmod($number, 1000000));
    }

    $divider = 100000;
    $pos     = 0;
    while ($number > 0) {
        $d = intval($number / $divider);
        $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" :
        ((($divider == 10) && ($d == 1)) ? "" :
            ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
        $ret .= ($d ? $position_call[$pos] : "");
        $number  = $number % $divider;
        $divider = $divider / 10;
        $pos++;
    }
    return $ret;
}

function dbAction($action, $success_msg = null)
{
    try {
        return \DB::transaction(function () use ($action, $success_msg) {
            if ($success_msg !== null) {
                session()->flash('notification', [
                    'status'  => 'success',
                    'heading' => 'Success',
                    'msg'     => $success_msg,
                ]);
            }
            return $action();
        });
    } catch (\Illuminate\Database\QueryException $ex) {
        session()->flash('notification', [
            'status'  => 'error',
            'heading' => 'Error',
            'msg'     => "Something went wrong!",
        ]);
        return redirect()->back();
    }
}

function dbChecker($result)
{

    if ($result->isEmpty() || $result === null) {
        session()->flash('notification', [
            'status'  => 'error',
            'heading' => 'Error',
            'msg'     => "The operation not found!",
        ]);
        return redirect()->back();
    }

}

function preventDobleSubmit($uuid)
{
    $check = \App\SubmitUuid::find($uuid);
    if ($check !== null) {
        $submituuid       = new \App\SubmitUuid;
        $submituuid->uuid = $uuid;
        $submituuid->save();
    } else {
        return redirect('/');
    }
}

function defaultEmpty($var)
{
    return (is_null($var)) ? ' ' : $var;
}


function canAccess(...$list){
    $auth_role = Auth::user()->role;
    if(!in_array('admin', $list)){
        array_push($list, 'admin');
    }
    if(in_array($auth_role, $list)){
        return true;
    }
    return false;
}
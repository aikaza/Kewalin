<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\LocationTrait;
use App\Traits\CustomerTrait;
use App\Http\Requests\StoreCustomer;

class CustomerController extends Controller
{



    use CustomerTrait;




    public function index()
    {
        return view('customer.index');
    }




    public function create()
    {
        return view('customer.create');
    }




    public function store(StoreCustomer $rq)
    {
        return dbAction(function() use ($rq){
            extract($rq->all());
            $ct = new \App\Customer;
            $ct->first_name = $first_name;
            $ct->last_name  = defaultEmpty($last_name);
            $ct->alias_name = defaultEmpty($alias_name);
            $ct->email      = defaultEmpty($email);
            $ct->phone_no   = defaultEmpty($phone_no);
            $ct->address    = defaultEmpty($address);
            $ct->save();
            return redirect()->route('customers.create');
        },'เพิ่มลูกค้าเรียบร้อยแล้ว');
    }




    public function edit($id)
    {
        $ct = \App\Customer::find($id);
        $tosend = [ 'ct' => $ct ];
        return view('customer.edit',$tosend);
    }




    public function update(StoreCustomer $rq, $id)
    {
        return dbAction(function() use ($rq,$id){
            extract($rq->all());
            $ct = \App\Customer::find($id);
            $ct->first_name = $first_name;
            $ct->last_name  = defaultEmpty($last_name);
            $ct->alias_name = defaultEmpty($alias_name);
            $ct->email      = defaultEmpty($email);
            $ct->phone_no   = defaultEmpty($phone_no);
            $ct->address    = defaultEmpty($address);
            $ct->save();
            return redirect()->route('customers.edit',$id);
        },'แก้ไขข้อมูลเรียบร้อยแล้ว');
    }




    public function delete($id)
    {
        $tosend = [
            'ct'  => \App\Customer::find($id),
            'export_data_count' => $this->countRecords($id,new \App\Export,['orders','exports.order_id','orders.id']),
            'order_data_count'  => $this->countRecords($id,new \App\Order),
            'debt_data_count'  => $this->countRecords($id,new \App\Invoice)
        ];

        return view('customer.delete',$tosend);
    }




    public function destroy($id)
    {
        return dbAction(function() use ($id){
            $ct = \App\Customer::find($id);
            $ct->delete();
            return redirect()->route('customers.index');
        },'ลบข้อมูลลูกค้าเรียบร้อยแล้ว');
    }




    public function detail($id)
    {
        $tosend = [ 'ct' => \App\Customer::find($id) ];
        return view('customer.detail',$tosend);
    }
}

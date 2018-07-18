<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use App\Http\Requests\EditUser;
use App\Http\Requests\ChangePassword;

class UserController extends Controller
{




    public function index()
    {
        $users = \App\User::where('role','<>','admin')->get();
        $tosend = [ 'users' => $users ];
        return view('user.index',$tosend);
    }




    public function store(StoreUser $rq)
    {
        return dbAction(function() use($rq){
            extract($rq->all());
            $user = new \App\User;
            $user->name = $name;
            $user->username = $username;
            $user->password = bcrypt($password);
            $user->role = $role;
            $user->save();
            return redirect()->route('users.index');
        }, 'เพิ่มผู้ใช้เรียบร้อยแล้ว');
    }




    public function update(EditUser $rq, $id)
    {
        return dbAction(function() use ($rq,$id){
            extract($rq->all());
            $user = \App\User::find($id);
            $user->name = $name;
            $user->username = $username;
            $user->role = $role;
            $user->save();
            return redirect()->route('users.index');
        }, 'แก้ไขเรียบร้อยแล้ว');
    }


    public function changePassword(ChangePassword $rq, $user_id)
    {
        return dbAction(function() use ($rq,$user_id){
            $user = \App\User::find($user_id);
            $user->password = bcrypt($rq->new_password);
            $user->save();
            return redirect()->back();
        }, 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว');
    }


    public function changeName(Request $rq, $user_id){
        return dbAction(function() use ($rq, $user_id){
            $user = \App\User::find($user_id);
            $user->name = $rq->name;
            $user->save();
            return redirect()->back();
        }, 'บันทึกเรียบร้อยแล้ว');
    }




}

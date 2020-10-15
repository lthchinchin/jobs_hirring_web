<?php

namespace App\Http\Controllers;

use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use League\CommonMark\Inline\Element\Code;

class accoutController extends Controller
{
    public function acc_truePass(Request $request)
    {
        $email = $request->email;
        $password = md5($request->password);

        $result = DB::table('users')->where('email', $email)->where('password', $password)->first();
        if ($result) {
            if ($result->isAdmin == 1) {
                Session::put('acc_name', $result->name);
                Session::put('acc_id', $result->id);
                Session::put('acc_level', $result->isAdmin);
                echo "<script>alert('Đăng nhập thành công!');
                window.location.href='admin-jobhiring';
                </script>";
            }else{
                Session::put('acc_name', $result->name);
                Session::put('acc_id', $result->id);
                Session::put('acc_level', $result->isAdmin);
                echo "<script>alert('Đăng nhập thành công!');
                window.location.href='diagram';
                </script>";
            }
        } else {
            // return view('login', compact('request'));
            // return Redirect::to('/login');
            // return $request->password;
            echo "<script>alert('Mật khẩu không đúng!');
                window.location.href='login';
                </script>";
        }
    }


    public function acc_logout()
    {
        Session::forget('acc_name');
        Session::forget('acc_id');
        Session::forget('acc_level');
        //        
        //        Session::put('admin_name', null);
        //        Session::put('admin_id', null);
        return Redirect::to('/login');
    }
}

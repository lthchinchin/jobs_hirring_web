<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class AccountmanageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Session('acc_id') != null) {
            if (Session('acc_level') == 1) {

                $users = DB::table('users')->select()->orderBy('id', 'DESC')->get();
                // dd($users);
                if ($request->ajax()) {
                    return DataTables::of($users)
                        ->addIndexColumn()
                        ->addColumn('checkbox', function ($users) {
                            return '<div style="text-align:center" ><input type="checkbox" id="master" name="checkAll" class="checkSingle" data-id="' . $users->id . '"></div>';
                        })
                        ->addColumn('role', function ($users) {

                            switch ($users->isAdmin) {
                                case "1":
                                    return '<p style="text-align:center">Admin</p>';
                                    break;
                                case "2":
                                    return '<p style="text-align:center">Manager</p>';
                                    break;
                                case "0":
                                    return '<p style="text-align:center">User default</p>';
                                    break;
                                case "-1":
                                    return '<p style="text-align:center">User block Create Topic</p>';
                                    break;
                                case "-2":
                                    return '<p style="text-align:center">User block Comment Topic</p>';
                                    break;
                                case "-3":
                                    return '<p style="text-align:center">User block Create & Comment</p>';
                                    break;
                            }
                        })
                        ->addColumn('action', function ($row) {
                            //javascript:void(0) được sử dụng để ngăn trình duyệt chuyển tiếp người dùng sang trang khác. Ngoài việc sử dụng href="javascript:void(0)" bạn cũng có thể sử dụng href="#" để thực hiện cùng một mục đích.
                            $btn = '<a href="#" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editAccount">Edit</a>';

                            $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteAccount">Delete</a>';

                            return $btn;
                        })
                        ->rawColumns(['action', 'role', 'checkbox'])
                        ->make(true);
                }
                return view('admin.edit_account', compact('users'));
            } else {
                return Redirect::to('/diagram');
            }
        } else
            return Redirect::to('/login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->user_id != null) {
            if (isset($request->newpassword) && $request->newpassword != null) {
                $check = DB::table('users')
                    ->select('password')
                    ->where('id', $request->user_id)
                    ->where('password', MD5($request->password))
                    ->count();
                if ($check == 1) {
                    DB::table('users')
                        ->where('id', $request->user_id)
                        ->update([
                            'name' => $request->username,
                            'password' => MD5($request->newpassword)
                        ]);
                    $response = [
                        'success' => true,
                        'message' => 'Change password successfully.',
                    ];
                }
                else{
                    $response = [
                        'success' => true,
                        'message' => 'Change password fail, Old password incorrect.',
                    ];
                }
            } else {
                DB::table('users')
                    ->where('id', $request->user_id)
                    ->update([
                        'name' => $request->username,
                        'isAdmin' => $request->level
                    ]);
                $response = [
                    'success' => true,
                    'message' => 'update successfully.',
                ];
            }
        } else {
            $count = DB::table('users')->select('email')->where('email', '=', $request->email)->count();
            if ($count != 1) {
                DB::table('users')->insert(
                    [
                        'name' => $request->username,
                        'email' => $request->email,
                        'password' => MD5($request->password),
                        'isAdmin' => $request->level
                    ]
                );
                // return response
                $response = [
                    'success' => true,
                    'message' => 'Tạo tài khoản thành công.',
                ];
            } else {
                $response = [
                    'success' => true,
                    'message' => 'Email đã tồn tại chọn email khác.',
                ];
            }
        }
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = DB::table('users')->where('id', '=', $id)->first();
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('users')->where('id', '=', $id)->delete();
        $response = [
            'success' => true,
            'message' => 'delete successfully.',
        ];
        return response()->json($response, 200);
    }

    public function multidelpost($id)
    {
        if (Session('acc_level') == 1) {
            $ids = explode(",", $id);
            foreach ($ids as $value) {
                DB::table('users')->where('id', '=', $value)->delete();
            }
            return response()->json([
                'del' => $ids
            ]);
        } else {
            return Redirect::to('/');
        }
    }
}

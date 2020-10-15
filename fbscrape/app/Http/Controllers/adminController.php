<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Redirect;

class adminController extends Controller
{
    public function index(Request $request)
    {
        if (Session('acc_id') != null) {
            if (Session('acc_level') == 1) {
                //$books = Brand_ajax::latest()->get();
                $books = Job::select()->orderBy('id', 'DESC')->get();
                if ($request->ajax()) {
                    return DataTables::of($books)
                        ->addIndexColumn()
                        ->addColumn('checkbox', function ($books) {
                            return '<div style="text-align:center" ><input type="checkbox" id="master" name="checkAll" class="checkSingle" data-id="' . $books->id . '"></div>';
                        })
                        ->addColumn('testcol', function ($books) {
                            return '<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" width="150px">' . $books->post_desc . '</textarea>';
                        })
                        ->addColumn('status', function ($books) {
                            if ($books->status == 0)
                                return '<a href="#" data-id="' . $books->id . '" data-original-title="displayactive" class="edit btn btn-success btn-sm display">Display</a>';
                            else
                                return '<a href="#" data-id="' . $books->id . '" data-original-title="hideactive" class="edit btn btn-secondary btn-sm hide">Hide</a>';
                        })
                        ->addColumn('action', function ($row) {
                            //                    javascript:void(0) được sử dụng để ngăn trình duyệt chuyển tiếp người dùng sang trang khác. Ngoài việc sử dụng href="javascript:void(0)" bạn cũng có thể sử dụng href="#" để thực hiện cùng một mục đích.
                            $btn = '<a href="#" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editBook">Edit</a>';

                            $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook">Delete</a>';

                            return $btn;
                        })
                        ->rawColumns(['testcol', 'status', 'action', 'checkbox'])
                        ->make(true);
                }
                return view('admin.edit_table', compact('books'));
            } else {
                return Redirect::to('/diagram');
            }
        } else
            return Redirect::to('/login');
    }
    public function store(Request $request)
    {
        Job::updateOrCreate([
            'id' => $request->book_id
        ], [
            'company_name' => $request->companyname,
            'company_mail' => $request->companymail,
            'programing_language' => $request->pl,
            'job_position' => $request->jobposition,
            'link_post' => $request->link,
            'post_desc' => $request->desc,
            'status' => $request->status

        ]);

        // return response
        $response = [
            'success' => true,
            'message' => 'Book saved successfully.',
        ];
        return response()->json($response, 200);
    }


    public function edit($id)
    {
        $book = Job::where('id', '=', $id)->firstOrFail();
        return response()->json($book);
    }

    public function change_status($id)
    {
        $stt = Job::where('id', '=', $id)->value('status');
        if ($stt == 0) {
            $book = Job::where('id', '=', $id)->update(['status' => 1]);
            return response()->json([
                'msg' => 'status is hide'
            ]);
        } else {
            $book = Job::where('id', '=', $id)->update(['status' => 0]);
            return response()->json([
                'msg' => 'status is display'
            ]);
        }
        // return response()->json($book);
    }

    public function delpost($id)
    {
        $res = Job::destroy($id);
        if ($res) {
            return response()->json([
                'status' => '1',
                'msg' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => '0',
                'msg' => 'fail'
            ]);
        }
        // return response()->json($book);
    }

    public function multidelpost($id)
    {
        if (Session('acc_level') == 1) {
            $ids = explode(",", $id);
            foreach ($ids as $value) {
                Job::destroy($value);
            }
            return response()->json([
                'del' => $ids
            ]);
        }else{
            return Redirect::to('/');
        }

        // $res = Job::destroy($id);
        // if ($res) {
        //     return response()->json([
        //         'arr' => $id,
        //         'msg' => 'del success'
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => '0',
        //         'msg' => 'fail'
        //     ]);
        // }

        // return response()->json($book);
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($brand_ajax)
    {
        //        $brand_ajax->delete();
        //
        //        // return response
        //        $response = [
        //            'success' => true,
        //            'message' => 'Book deleted successfully.',
        //        ];
        //        return response()->json($response, 200);
        $res = Job::destroy($brand_ajax);
        if ($res) {
            return response()->json([
                'status' => '1',
                'msg' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => '0',
                'msg' => 'fail'
            ]);
        }
    }
}

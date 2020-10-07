<?php

namespace App\Http\Controllers;

use App\Brand_ajax;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BrandAjaxController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //        $books = Brand_ajax::latest()->get();
        $books = Brand_ajax::select()->get();
        if ($request->ajax()) {
            return Datatables::of($books)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    //                    javascript:void(0) được sử dụng để ngăn trình duyệt chuyển tiếp người dùng sang trang khác. Ngoài việc sử dụng href="javascript:void(0)" bạn cũng có thể sử dụng href="#" để thực hiện cùng một mục đích.
                    $btn = '<a href="#" data-toggle="tooltip"  data-id="' . $row->brand_id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editBook">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->brand_id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.brandajax', compact('books'));
    }

    /**
     * Store/update resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Brand_ajax::updateOrCreate([
            'brand_id' => $request->book_id
        ], [
            'brand_name' => $request->brandname,
            'brand_status' => $request->status
        ]);

        // return response
        $response = [
            'success' => true,
            'message' => 'Book saved successfully.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Book $books
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Brand_ajax::where('brand_id', '=', $id)->firstOrFail();
        return response()->json($book);
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
        $res = Brand_ajax::destroy($brand_ajax);
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

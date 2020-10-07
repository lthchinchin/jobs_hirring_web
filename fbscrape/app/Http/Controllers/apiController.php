<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;

class apiController extends Controller
{
    public function index()
    {
        $stt = Job::all()->take(10);
        return response()->json([
            'msg' => 'display',
            'data' => $stt
        ], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        // return response()->json($stt, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}

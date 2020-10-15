<?php

namespace App\Http\Controllers;

use \Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class datascrapeController extends Controller
{
    public function data_display()
    {
        $job = DB::table('tbl_job_hirring')->orderBy('id', 'DESC')->where('status', '=', 0)->get();

        if (Session('acc_id') == null || Session('acc_level') != 1) {
            $txtdog = file_get_contents("https://random.dog/woof.json");
            $txtdog2 = file_get_contents("https://random.dog/woof.json");
            // while (strpos($txtdog, '.mp4') == true) {
            //     $txtdog = file_get_contents("https://random.dog/woof.json");
            // }
            // while (strpos($txtdog2, '.mp4') == true) {
            //     $txtdog2 = file_get_contents("https://random.dog/woof.json");
            // }
            $dog = json_decode($txtdog);
            $dog2 = json_decode($txtdog2);
            return view('user.show_data', compact('dog', 'dog2', 'job'));
        } else {
            return view('user.show_data', compact('job'));
        }
    }
    public function login()
    {
        if (Session('acc_id') == null) {
            return view('login');
        } else {
            return redirect('admin-jobhiring');
        }
    }

    public function randomdog()
    {
        $txtdog = file_get_contents("https://random.dog/woof.json");
        while (strpos($txtdog, '.mp4') == true) {
            $txtdog = file_get_contents("https://random.dog/woof.json");
        }
        $dog = json_decode($txtdog);
        $countries = json_decode(file_get_contents("https://restcountries.eu/rest/v2/all"));
        // echo gettype($job);
        // echo gettype($countries);
        // $urldog = $dog->url;
        // dd($dog);
        // for ($i = 0; $i < count($countries); $i++) {
        //     echo $countries[$i]->name.',';
        // }
        return view('user.randomdog', compact('dog'), compact('countries'));
    }
}

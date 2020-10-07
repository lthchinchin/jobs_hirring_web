<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;
// use \Illuminate\Support\Facades\DB;
// use App\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class chartController extends Controller
{
    public function diagramshow()
    {
        // $isAdmin = DB::table('users')->where('isAdmin', '=', 1)->count();
        // $notisAdmin = DB::table('users')->where('isAdmin', '=', 0)->count();
        $currentMonth = Carbon::now()->month;
        $currentMonth_minus1 = $currentMonth - 1;
        $currentMonth_minus2 = $currentMonth - 2;
        $job = Job::select('id', 'programing_language')->distinct()->where('programing_language', 'like', '%php%')
            ->whereMonth('status', '=', 0)
            ->whereMonth('created_at', '=', Carbon::now())->take(5)->get();
        // foreach ($job as $x) {
        //     array_push($z, $x->programing_language);
        // }; 

        $chart = (new LarapexChart)->setTitle('Diagram current month : ' . Carbon::now()->month . '-' . Carbon::now()->year)
            ->setDataset([
                Job::where('programing_language', 'like', '%php%')
                    ->whereMonth('status', '=', 0)
                    ->whereMonth('created_at', '=', Carbon::now())->count(),
                Job::where('programing_language', 'like', '%java%')
                    ->whereMonth('status', '=', 0)
                    ->whereMonth('created_at', '=', Carbon::now())->count(),
                Job::where('programing_language', 'like', '%ruby%')
                    ->whereMonth('status', '=', 0)
                    ->whereMonth('created_at', '=', Carbon::now())->count()
            ])
            // ->setDataset([User::where('isAdmin', '=', 1)->count(), User::where('isAdmin', '=', 0)->count()])
            ->setColors(['#ffc63b', '#ff6384', '#5203fc'])
            ->setLabels(['PHP', 'Java', 'Ruby']);

        // ->setLabels($z);


        $chart2 = (new LarapexChart)->setType('line')
            ->setTitle('Total Users Monthly')
            ->setSubtitle('From ' . $currentMonth_minus2 . '-' . Carbon::now()->year . ' to ' . $currentMonth . '-' . Carbon::now()->year . '.')
            ->setXAxis([
                $currentMonth_minus2 . '-' . Carbon::now()->year,
                $currentMonth_minus1 . '-' . Carbon::now()->year,
                $currentMonth . '-' . Carbon::now()->year
            ])
            ->setDataset([
                [
                    'name'  =>  'PHP',
                    'data'  =>  [
                        Job::where('programing_language', 'like', '%php%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus2)->count(),
                        Job::where('programing_language', 'like', '%php%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus1)->count(),
                        Job::where('programing_language', 'like', '%php%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth)->count()
                    ]

                ],
                [
                    'name'  =>  'Java',
                    'data'  =>  [
                        Job::where('programing_language', 'like', '%java%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus2)->count(),
                        Job::where('programing_language', 'like', '%java%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus1)->count(),
                        Job::where('programing_language', 'like', '%java%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth)->count()
                    ]

                ],
                [
                    'name'  =>  'Ruby',
                    'data'  =>  [
                        Job::where('programing_language', 'like', '%ruby%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus2)->count(),
                        Job::where('programing_language', 'like', '%ruby%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus1)->count(),
                        Job::where('programing_language', 'like', '%ruby%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth)->count()
                    ]
                ],
            ]);

        return view('user.show_diagram', compact('chart', 'chart2'));
    }
    // -------------------------------------------
    public function diagramshowplus($pl)
    {
        $plname = ucwords(strval($pl));
        // echo ucwords();
        // $isAdmin = DB::table('users')->where('isAdmin', '=', 1)->count();
        // $notisAdmin = DB::table('users')->where('isAdmin', '=', 0)->count();
        $currentMonth = Carbon::now()->month;
        $currentMonth_minus1 = $currentMonth - 1;
        $currentMonth_minus2 = $currentMonth - 2;

        $chart = (new LarapexChart)->setTitle('Diagram current month : ' . Carbon::now()->month . '-' . Carbon::now()->year)
            ->setDataset([
                Job::where('programing_language', 'like', '%php%')
                    ->whereMonth('status', '=', 0)
                    ->whereMonth('created_at', '=', Carbon::now())->count(),
                Job::where('programing_language', 'like', '%java%')
                    ->whereMonth('status', '=', 0)
                    ->whereMonth('created_at', '=', Carbon::now())->count(),
                Job::where('programing_language', 'like', '%ruby%')
                    ->whereMonth('status', '=', 0)
                    ->whereMonth('created_at', '=', Carbon::now())->count()
            ])
            // ->setDataset([User::where('isAdmin', '=', 1)->count(), User::where('isAdmin', '=', 0)->count()])
            ->setColors(['#ffc63b', '#ff6384', '#5203fc'])
            ->setLabels(['PHP', 'Java', 'Ruby']);

        // ->setLabels($z);


        $chart2 = (new LarapexChart)->setType('line')
            ->setTitle('Total Users Monthly')
            ->setSubtitle('From ' . $currentMonth_minus2 . '-' . Carbon::now()->year . ' to ' . $currentMonth . '-' . Carbon::now()->year . '.')
            ->setXAxis([
                $currentMonth_minus2 . '-' . Carbon::now()->year,
                $currentMonth_minus1 . '-' . Carbon::now()->year,
                $currentMonth . '-' . Carbon::now()->year
            ])
            ->setDataset([
                [
                    'name'  =>  'PHP',
                    'data'  =>  [
                        Job::where('programing_language', 'like', '%php%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus2)->count(),
                        Job::where('programing_language', 'like', '%php%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus1)->count(),
                        Job::where('programing_language', 'like', '%php%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth)->count()
                    ]

                ],
                [
                    'name'  =>  'Java',
                    'data'  =>  [
                        Job::where('programing_language', 'like', '%java%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus2)->count(),
                        Job::where('programing_language', 'like', '%java%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus1)->count(),
                        Job::where('programing_language', 'like', '%java%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth)->count()
                    ]

                ],
                [
                    'name'  =>  'Ruby',
                    'data'  =>  [
                        Job::where('programing_language', 'like', '%ruby%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus2)->count(),
                        Job::where('programing_language', 'like', '%ruby%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus1)->count(),
                        Job::where('programing_language', 'like', '%ruby%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth)->count()
                    ]
                ],
                [
                    'name'  =>  $plname,
                    'data'  =>  [
                        Job::where('programing_language', 'like', '%' . $pl . '%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus2)->count(),
                        Job::where('programing_language', 'like', '%' . $pl . '%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus1)->count(),
                        Job::where('programing_language', 'like', '%' . $pl . '%')
                            ->whereMonth('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth)->count()
                    ]

                ],
            ]);

        return view('user.show_diagram', compact('chart', 'chart2'));
    }
}

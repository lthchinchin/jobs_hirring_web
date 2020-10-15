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
            ->where('status', '=', 0)
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
            // ->setColors(['#ffc63b', '#ff6384', '#5203fc'])
            ->setStroke(2)
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
                            ->where('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus2)->count(),
                        Job::where('programing_language', 'like', '%php%')
                            ->where('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus1)->count(),
                        Job::where('programing_language', 'like', '%php%')
                            ->where('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth)->count()
                    ]

                ],
                [
                    'name'  =>  'Java',
                    'data'  =>  [
                        Job::where('programing_language', 'like', '%java%')
                            ->where('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus2)->count(),
                        Job::where('programing_language', 'like', '%java%')
                            ->where('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus1)->count(),
                        Job::where('programing_language', 'like', '%java%')
                            ->where('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth)->count()
                    ]

                ],
                [
                    'name'  =>  'Ruby',
                    'data'  =>  [
                        Job::where('programing_language', 'like', '%ruby%')
                            ->where('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus2)->count(),
                        Job::where('programing_language', 'like', '%ruby%')
                            ->where('status', '=', 0)
                            ->whereMonth('created_at', '=', $currentMonth_minus1)->count(),
                        Job::where('programing_language', 'like', '%ruby%')
                            ->where('status', '=', 0)
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
                    ->whereMonth('created_at', '=', Carbon::now())->count(),
                Job::where('programing_language', 'like', '%'.$pl.'%')
                    ->whereMonth('status', '=', 0)
                    ->whereMonth('created_at', '=', Carbon::now())->count()
            ])
            // ->setDataset([User::where('isAdmin', '=', 1)->count(), User::where('isAdmin', '=', 0)->count()])
            // ->setColors(['#ffc63b', '#ff6384', '#5203fc'])
            ->setStroke(2)
            ->setLabels(['PHP', 'Java', 'Ruby',$pl]);
            

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

    public function diagramshow2()
    {
        $currentMonth = Carbon::now()->month;
        $currentMonth_minus1 = $currentMonth - 1;
        $currentMonth_minus2 = $currentMonth - 2;
        $job = Job::select('id', 'programing_language')->distinct()->where('programing_language', 'like', '%php%')
            ->where('status', '=', 0)
            ->whereMonth('created_at', '=', Carbon::now())->take(5)->get();

        $company = Job::select('company_name', Job::raw('COUNT(company_name) as hirring_quantity'))->groupBy('company_name')->get();
        // dd($company);
        $chart = (new LarapexChart)->setTitle('Quantity jobs hirring each Company')
            ->setSubtitle('Company')
            ->setType('bar')
            ->setHorizontal(true)
            ->setXAxis([''])
            ->setGrid(true)
            ->setDataset([
                [
                    'name'  => 'Fsoft',
                    'data'  => [Job::where('company_name', '=', 'Fsoft')->where('status', '=', 0)->count()]
                ],
                [
                    'name'  => 'Outsource',
                    'data'  => [Job::where('company_name', '=', 'Outsource')->where('status', '=', 0)->count()]
                ],
                [
                    'name'  => 'Nfq',
                    'data'  => [Job::where('company_name', '=', 'Nfq')->where('status', '=', 0)->count()]
                ],
            ])
            ->setStroke(1);

        $chart2 = (new LarapexChart)->setTitle('Net Profit')
            ->setSubtitle('From ' . $currentMonth_minus2 . '-' . Carbon::now()->year . ' to ' . $currentMonth . '-' . Carbon::now()->year . '.')
            ->setType('bar')
            ->setXAxis([
                $currentMonth_minus2 . '-' . Carbon::now()->year,
                $currentMonth_minus1 . '-' . Carbon::now()->year,
                $currentMonth . '-' . Carbon::now()->year
            ])
            ->setGrid(true)
            ->setDataset([
                [
                    'name'  => 'Fsoft',
                    'data'  =>  [
                        Job::where('company_name', '=', 'Fsoft')->whereMonth('created_at', '=', $currentMonth_minus2)->where('status', '=', 0)->count(),
                        Job::where('company_name', '=', 'Fsoft')->whereMonth('created_at', '=', $currentMonth_minus1)->where('status', '=', 0)->count(),
                        Job::where('company_name', '=', 'Fsoft')->whereMonth('created_at', '=', $currentMonth)->where('status', '=', 0)->count()
                    ]
                ],
                [
                    'name'  => 'Outsource',
                    'data'  =>  [
                        Job::where('company_name', '=', 'Outsource')->whereMonth('created_at', '=', $currentMonth_minus2)->where('status', '=', 0)->count(),
                        Job::where('company_name', '=', 'Outsource')->whereMonth('created_at', '=', $currentMonth_minus1)->where('status', '=', 0)->count(),
                        Job::where('company_name', '=', 'Outsource')->whereMonth('created_at', '=', $currentMonth)->where('status', '=', 0)->count()
                    ]
                ],
                [
                    'name'  => 'Nfq',
                    'data'  =>  [
                        Job::where('company_name', '=', 'Nfq')->whereMonth('created_at', '=', $currentMonth_minus2)->where('status', '=', 0)->count(),
                        Job::where('company_name', '=', 'Nfq')->whereMonth('created_at', '=', $currentMonth_minus1)->where('status', '=', 0)->count(),
                        Job::where('company_name', '=', 'Nfq')->whereMonth('created_at', '=', $currentMonth)->where('status', '=', 0)->count()
                    ]
                ]
            ])
            ->setStroke(1);

        return view('user.show_diagram2', compact('chart', 'chart2', 'company'));
    }

    public function diagramshowplus2($cn)
    {
        $currentMonth = Carbon::now()->month;
        $currentMonth_minus1 = $currentMonth - 1;
        $currentMonth_minus2 = $currentMonth - 2;
        $job = Job::select('id', 'programing_language')->distinct()->where('programing_language', 'like', '%php%')
            ->where('status', '=', 0)
            ->whereMonth('created_at', '=', Carbon::now())->take(5)->get();

        $company = Job::select('company_name', Job::raw('COUNT(company_name) as hirring_quantity'))->where('status', '=', 0)->groupBy('company_name')->get();
        // dd($company);
        $chart = (new LarapexChart)->setTitle('Quantity jobs hirring each Company')
            ->setSubtitle('Company')
            ->setType('bar')
            ->setHorizontal(true)
            ->setXAxis([''])
            ->setGrid(true)
            ->setDataset([
                [
                    'name'  => 'Fsoft',
                    'data'  => [Job::where('company_name', '=', 'Fsoft')->where('status', '=', 0)->count()]
                ],
                [
                    'name'  => 'Outsource',
                    'data'  => [Job::where('company_name', '=', 'Outsource')->where('status', '=', 0)->count()]
                ],
                [
                    'name'  => 'Nfq',
                    'data'  => [Job::where('company_name', '=', 'Nfq')->where('status', '=', 0)->count()]
                ],
                [
                    'name'  => $cn,
                    'data'  => [Job::where('company_name', '=', $cn)->where('status', '=', 0)->count()]
                ]
            ])
            ->setStroke(1);

        $chart2 = (new LarapexChart)->setTitle('Net Profit')
            ->setSubtitle('From ' . $currentMonth_minus2 . '-' . Carbon::now()->year . ' to ' . $currentMonth . '-' . Carbon::now()->year . '.')
            ->setType('bar')
            ->setXAxis([
                $currentMonth_minus2 . '-' . Carbon::now()->year,
                $currentMonth_minus1 . '-' . Carbon::now()->year,
                $currentMonth . '-' . Carbon::now()->year
            ])
            ->setGrid(true)
            ->setDataset([
                [
                    'name'  => 'Fsoft',
                    'data'  =>  [
                        Job::where('company_name', '=', 'Fsoft')->whereMonth('created_at', '=', $currentMonth_minus2)->where('status', '=', 0)->count(),
                        Job::where('company_name', '=', 'Fsoft')->whereMonth('created_at', '=', $currentMonth_minus1)->where('status', '=', 0)->count(),
                        Job::where('company_name', '=', 'Fsoft')->whereMonth('created_at', '=', $currentMonth)->where('status', '=', 0)->count()
                    ]
                ],
                [
                    'name'  => 'Outsource',
                    'data'  =>  [
                        Job::where('company_name', '=', 'Outsource')->whereMonth('created_at', '=', $currentMonth_minus2)->where('status', '=', 0)->count(),
                        Job::where('company_name', '=', 'Outsource')->whereMonth('created_at', '=', $currentMonth_minus1)->where('status', '=', 0)->count(),
                        Job::where('company_name', '=', 'Outsource')->whereMonth('created_at', '=', $currentMonth)->where('status', '=', 0)->count()
                    ]
                ],
                [
                    'name'  => 'Nfq',
                    'data'  =>  [
                        Job::where('company_name', '=', 'Nfq')->whereMonth('created_at', '=', $currentMonth_minus2)->where('status', '=', 0)->count(),
                        Job::where('company_name', '=', 'Nfq')->whereMonth('created_at', '=', $currentMonth_minus1)->where('status', '=', 0)->count(),
                        Job::where('company_name', '=', 'Nfq')->whereMonth('created_at', '=', $currentMonth)->where('status', '=', 0)->count()
                    ]
                ],
                [
                    'name'  => $cn,
                    'data'  =>  [
                        Job::where('company_name', '=', $cn)->whereMonth('created_at', '=', $currentMonth_minus2)->where('status', '=', 0)->count(),
                        Job::where('company_name', '=', $cn)->whereMonth('created_at', '=', $currentMonth_minus1)->where('status', '=', 0)->count(),
                        Job::where('company_name', '=', $cn)->whereMonth('created_at', '=', $currentMonth)->where('status', '=', 0)->count()
                    ]
                ]

            ])
            ->setStroke(1);

        return view('user.show_diagram2', compact('chart', 'chart2', 'company'));
    }
}

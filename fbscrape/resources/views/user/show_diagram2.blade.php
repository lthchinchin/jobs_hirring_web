@extends('welcome2')
@section('content')
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<?php
// echo $company;
?>


<div class="container-fluid">
    <br>
    <h2 class="text-center">Diagram of IT jobs hiring</h2>
    <br>
    <!-- <p>This part is inside a .container class.</p>  -->
    <div class="row">
        <div class="col-xl-4" style="background-color:lavender;">
            {!! $chart->container() !!}

            <script src="{{ $chart->cdn() }}"></script>

            {{ $chart->script() }}
        </div>
        <div class="col-xl-8" style="background-color:lavenderblush;">
            <div class="d-flex ">
                <div class="p-2 ml-auto">
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            Company
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{URL::to('/diagram2')}}">None</a>
                            @foreach($company as $c)
                            <?php
                            if ($c->company_name != "Fsoft" && $c->company_name != "Outsource" && $c->company_name != "Nfq") {
                            ?>
                                <a class="dropdown-item" href="{{URL::to('/diagram2-'.$c->company_name)}}">{{$c->company_name}}</a>
                            <?php
                            }
                            ?>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {!! $chart2->container() !!}

            <script src="{{ $chart2->cdn() }}"></script>

            {{ $chart2->script() }}
        </div>
    </div>
</div>



@endsection
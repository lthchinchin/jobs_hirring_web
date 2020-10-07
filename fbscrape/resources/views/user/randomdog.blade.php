@extends('welcome2')
@section('content')
<p id="demo"></p>
<!-- <h1>Random a dog</h1> -->


<p id="namectr"></p>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <h4 id ="pr">It's relax time.</h4>
            </div>
            <div class="col-sm-8">
                <h2>Countries table</h2>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-4">

                <img id='dogimg' src="{{$dog->url}}" height="400px" width=300px />
            </div>
            <div class="col-sm-8">
                <table id="dataTable" class="table table-light table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Capital</th>
                            <th>Region</th>
                            <th>Population</th>
                            <th>Flag</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $cout = 0 ?>
                        @foreach($countries as $c)
                        @if ($c->region == "Asia")
                        <tr>
                            <td>{{$c->name}}</td>
                            <td>{{$c->capital}}</td>
                            <td>{{$c->region}}</td>
                            <td>{{$c->population}}</td>
                            <td></td>
                        </tr>
                        <?php $cout = $cout + 1 ?>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
        
    //     var data = [
    //     [
    //         "123",
    //         "Test thuii"
    //     ],
    //     [
    //         "999",
    //         "let me test"
    //     ]
    // ]
    //     $('#pr').html(data[0][0])
    </script>
    @endsection('content')
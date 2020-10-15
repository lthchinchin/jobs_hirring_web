@extends('welcome2')
@section('content')
<?php
include_once 'format.php';
$fm = new Format();
$serial = 1;
?>
<title>Job hiring Display </title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
<div class="container-fluid">
    <br>
    <div class="text-center" style="margin: 20px 0px 20px 0px;"><br>
        <span class="text-secondary">
            <h2>Table job hiring</h2>
        </span>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <?php
            if (Session('acc_id') == null || Session('acc_level') != 1) {
            ?>
                <img id='dogimg' src="{{$dog->url}}" height="350px" width=250px />
                <!-- <img id='dogimg2' src="{{$dog->url}}" height="350px" width=250px /> -->
            <?php
            }
            ?>
        </div>
        <div class="col-sm-8">
            <table id="dataTable" class="table table-hover">
                <thead>
                    <tr>
                        <th>Serial </th>
                        <th>Company Name</th>
                        <th>Company mail</th>
                        <th>Programing language</th>
                        <th>Job position</th>
                        <th>Post description</th>
                        <th>Day</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($job as $job)
                    <tr>
                        <!-- <td>{{$job->id}}</td> -->
                        <td>{{$serial}}</td>
                        <td>{{$job->company_name}}</td>
                        <td>{{$job->company_mail}}</td>
                        <td>{{$job->programing_language}}</td>
                        <td>{{$job->job_position}}</td>
                        <td><a href="{{$job->link_post}}" data-toggle="tooltip" data-placement="left" title="<?php echo $fm->textShorten($job->post_desc, 300) ?>"><?php echo $fm->textShorten($job->post_desc, 40) ?></a></td>
                        <td><?php echo date('Y-m-d', strtotime($job->created_at));?></td>
                    </tr>
                    <?php $serial = $serial + 1; ?>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Serial</th>
                        <th>Company Name</th>
                        <th>Company mail</th>
                        <th>Programing language</th>
                        <th>Job position</th>
                        <th>Post description</th>
                        <th>Day</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-sm-2">
            <?php
            if (Session('acc_id') == null || Session('acc_level') != 1) {
            ?>
                <img id='dogimg' src="{{$dog2->url}}" height="350px" width=250px />
                <!-- <img id='dogimg2' src="{{$dog2->url}}" height="350px" width=250px /> -->
            <?php
            }
            ?>
        </div>
    </div>
</div>

<style>
    #dogimg {

        margin-top: 50px;

    }

    th {
        text-align: center;
    }

    td {
        text-align: center;
    }
</style>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script>
    var data = [
        [
            "123",
            "Test thuii"
        ],
        [
            "999",
            "let me test"
        ]
    ]

    $(document).ready(function() {
        $('#dataTable').DataTable();
    });

    //scroll table $(document).ready(function() {
    //     var table = $('#dataTable').removeAttr('width').DataTable({
    //         scrollY: "300px",
    //         scrollX: true,
    //         scrollCollapse: true,
    //         paging: false,
    //         columnDefs: [{
    //             width: 200,
    //             targets: 0
    //         }],
    //         fixedColumns: true
    //     });
    // });
</script>
@endsection


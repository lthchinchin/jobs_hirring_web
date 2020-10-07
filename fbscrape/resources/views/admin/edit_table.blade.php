@extends('welcome2')
@section('content')

<title>Laravel 6.2 Ajax CRUD with DataTables Tutorial For Beginners - MyNotePaper.com</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!--    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> repeat sorting icon-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<style>
    #sttDisplay {
        color: greenyellow;
        font-weight: bold;
    }

    #sttHide {
        color: #dc3545;
        font-weight: bold;
    }

    th {
        text-align: center;
    }

    td {
        text-align: center;
    }
</style>
<div class="container-fluid">
    <div class="text-center" style="margin: 20px 0px 20px 0px;">
        <span class="text-secondary">Admin Control Table</span>
    </div>
    <div class="container-fluid">
        <div class="row">
            <h4 class="one">Jobs hirring</h4>
            <button class="btn btn-info ml-auto" id="createNewPost">Create job hirring</button>
            <button class="btn btn-danger ml-auto" id="deleteMultiple">Delete Multiple</button>
        </div>
    </div>
    <br>
    <table id="dataTable" class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Company Name</th>
                <th>Company Mail</th>
                <th>Programing Language</th>
                <th>Job Position</th>
                <th>Status</th>
                <th>Desc</th>
                <th>Action</th>
                <th>Created at</th>
                <th><input type="checkbox" name="checkedAll" id="checkedAll" /></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="bookForm" name="bookForm" class="form-horizontal">
                    <input type="hidden" name="book_id" id="book_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Company Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="companyname" name="companyname" placeholder="Enter company name" value="" maxlength="50" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Company mail</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="companymail" name="companymail" placeholder="Enter company mail" value="" maxlength="50" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">Programing Language</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="pl" name="pl" placeholder="Enter programing language" value="" maxlength="50" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Link Post</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="link" name="link" placeholder="Enter link" value="" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Job position</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="jobposition" name="jobposition" placeholder="Enter job position" value="" maxlength="50" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Desc</label>
                        <div class="col-sm-12">
                            <textarea type="text" class="form-control" rows="3" id="desc" name="desc" placeholder="Enter desc" value="" required="" autocomplete="off"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-12">
                            <select id="status" name="status" class="form-control">
                                <option value=0>Hiển Thị</option>
                                <option value=1>Ẩn</option>
                            </select>
                            <!-- <input type="number" class="form-control" id="status" name="status" value="0" required="" autocomplete="off"> -->
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- js del all -->
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            //jQuery add CSRF token to all $.post() requests' data
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    
</script>


<script type="text/javascript">
    $(function() {

        //ajax setup
        $.ajaxSetup({
            headers: {
                //jQuery add CSRF token to all $.post() requests' data
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        // datatable
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/admin-jobhirring') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, //khong can name:, 
                {
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'company_mail',
                    name: 'company_mail'
                },
                {
                    data: 'programing_language',
                    name: 'programing_language'
                },
                {
                    data: 'job_position',
                    name: 'job_position'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'testcol',
                    name: 'testcol',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $("#checkedAll").change(function() {
        if (this.checked) {
            $(".checkSingle").each(function() {
                this.checked = true;
            });
        } else {
            $(".checkSingle").each(function() {
                this.checked = false;
            });
        }
    });

    $(".checkSingle").click(function() {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingle").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#checkedAll").prop("checked", true);
            }
        } else {
            $("#checkedAll").prop("checked", false);
        }
    });

    //multiple delete

    $("#deleteMultiple").click(function() { 
        var allVals = [];
        $(".checkSingle:checked").each(function() {
            allVals.push($(this).attr('data-id'));
        });
        console.log(allVals);
        if (allVals.length != 0) {
            var result = confirm("Are You sure want to delete " + allVals.length + " entries?");
            if (result) {
                    $.get("{{ url('/multidel') }}" + '/' + allVals, function(data) {                 
                    alert(allVals.length + " entries are deleted");
                    table.draw();
                    console.log(data);
                });
            }
        } else {
            alert("There aren't any entry, please choose.");
        }

    });

        // create new book new book_id
        $('#createNewPost').click(function() {
            $('#saveBtn').html("Create");
            $('#book_id').val('');
            $('#bookForm').trigger("reset");
            $('#modelHeading').html("Create New Job Hirring");
            $('#ajaxModel').modal('show');
        });

        // create or update book
        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Saving..');

            $.ajax({
                data: $('#bookForm').serialize(),
                url: "{{ url('/admin-jobhirring') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#bookForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                    console.log('Success:', data);
                    $('#saveBtn').html('Save');
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save');
                }
            });
        });

        // edit book
        $('body').on('click', '.editBook', function() {
            var book_id = $(this).data('id');
            console.log('id:', book_id);
            //gui den va tra ve data
            $.get("{{ url('/admin-jobhirring') }}" + '/' + book_id + '/edit', function(data) {

                $('#modelHeading').html("Edit Job hirring");
                $('#saveBtn').html('Update');
                $('#ajaxModel').modal('show');
                $('#book_id').val(data.id);
                $('#companyname').val(data.company_name);
                $('#companymail').val(data.company_mail);
                $('#pl').val(data.programing_language);
                $('#link').val(data.link_post);
                $('#jobposition').val(data.job_position);
                $('#desc').val(data.post_desc);
                $('#status').val(data.status);
                console.log('back:', data.id);
                console.log('back:', data.company_name);
                console.log('back:', data.company_mail);
                console.log('back:', data.programing_language);
                console.log('back:', data.link_post);
                console.log('back:', data.job_position);
                console.log('back:', data.post_desc);
                console.log('back:', data.status);
            });
        });

        //change status
        $('body').on('click', '.display', function() {
            var book_id = $(this).data('id');
            console.log('id:', book_id);
            //gui den va tra ve data
            $.get("{{ url('/change-status') }}" + '/' + book_id, function(data) {
                table.draw();
                console.log('da dc tra ve!', data);
            });

        });

        $('body').on('click', '.hide', function() {
            var book_id = $(this).data('id');
            console.log('id:', book_id);
            //gui den va tra ve data
            $.get("{{ url('/change-status') }}" + '/' + book_id, function(data) {
                table.draw();
                console.log('da dc tra ve!', data.msg);

            });
        });

        // delete book
        $('body').on('click', '.deleteBook', function() {
            var book_id = $(this).data("id"); //get id tren the <a
            console.log('id:', book_id);
            var result = confirm("Are You sure want to delete !");
            if (result) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('/admin-jobhirring') }}" + '/' + book_id,
                    success: function(data) {
                        console.log('Success:', data);
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            }
        });

        // $('body').on('click', '.deleteBook', function() {
        //     var book_id = $(this).data('id');
        //     console.log('id:', book_id);
        //     //gui den va tra ve data
        //     $.get("{{ url('/del') }}" + '/' + book_id, function(data) {
        //         table.draw();
        //         console.log('da dc tra ve!',data.msg);
        //     });
        // });

    });
</script>
@endsection
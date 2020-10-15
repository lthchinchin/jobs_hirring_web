@extends('welcome2')
@section('content')

<title>Account manage</title>
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
        <span class="text-secondary">
            <h3>Admin Account Control Table</h3>
        </span>
    </div>
    <div class="container-fluid">
        <div class="row">
            <h4 class="one">Account</h4>
            <button class="btn btn-info ml-auto" id="createNewAcc">Create an Account</button>
            <button class="btn btn-danger ml-auto" id="deleteMultiple">Delete Multiple</button>
        </div>
    </div>
    <br>
    <table id="dataTable" class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Level</th>
                <th>Role</th>
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
                <h4 class="modal-title" id="modelHeading">Create Account</h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">User Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter user name" value="" maxlength="50" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" value="" maxlength="50" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Password</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password" name="password" value="" maxlength="50" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Level</label>
                        <div class="col-sm-12">
                            <select id="level" name="level" class="form-control">
                                <option value=0>User default</option>
                                <option value=1>Admin</option>
                                <option value=2>Manager</option>
                                <option value=-1>User block Create Topic</option>
                                <option value=-2>User block Comment Topic</option>
                                <option value=-3>User block Create & Comment</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-primary" id="saveBtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
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
            ajax: "{{ url('/admin-account') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, //khong can name:, 
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'isAdmin',
                    name: 'isAdmin'
                },
                {
                    data: 'role',
                    name: 'role'
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



        $('#createNewAcc').click(function() {
            $('#ajaxModel').modal('show');
        });

        $('#saveBtn').click(function(e) {
            e.preventDefault();
            var username = $('#username').val();
            var email = $('#email').val();
            var password = $('#password').val();
            if ($.trim(username) == '' || $.trim(email) == '' || $.trim(password) == '') {
                alert('Bạn không được chừa trống !');
                return false;
            } else {
                $(this).html('Saving..');
                $.ajax({
                    data: $('#Form').serialize(),
                    url: "{{ url('/admin-account') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#Form').trigger("reset");
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
            }
        });
    });
</script>

@endsection
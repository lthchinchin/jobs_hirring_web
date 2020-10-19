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
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

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
                            <p id='valid_username' style='color: red;'></p>
                        </div>
                    </div>
                    <div class="form-group" id="form-group-email">
                        <label for="name" class="col-sm-4 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" value="" maxlength="50" required="" autocomplete="off">
                            <p id='valid_email' style='color: red;'></p>
                        </div>
                    </div>
                    <div class="form-group" id="form-group-password">
                        <label for="name" class="col-sm-4 control-label">Password</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password" name="password" value="" maxlength="50" required="" autocomplete="off">
                            <p id='valid_password' style='color: red;'></p>
                        </div>
                    </div>
                    <div class="form-group" id="form-group-repassword">
                        <label for="name" class="col-sm-4 control-label">RePassword</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="repassword" name="repassword" value="" maxlength="50" required="" autocomplete="off">
                            <p id='valid_repassword' style='color: red;'></p>
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


        function validateEmail(email) {
            const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }


        $('#createNewAcc').click(function() {
            $('#ajaxModel').modal('show');
        });

        $('#saveBtn').click(function(e) {
            e.preventDefault();
            var username = $('#username').val();
            if (username == '') {
                $('#valid_username').html('<small>Không được chừa trống&nbsp<i class="fas fa-times"></i></small>');
                return false;
            }
            var email = $('#email').val();
            if (email == '') {
                $('#valid_email').html('<small>Không được chừa trống&nbsp<i class="fas fa-times"></i></small>');
                return false;
            } else {
                if (validateEmail(email) == false) {
                    $('#valid_email').html('<small>Example:&nbspnobita@gmail.com&nbsp<i class="fas fa-times"></i></small>');
                    return false;
                }
            }
            var password = $('#password').val();
            if (password == '') {
                $('#valid_password').html('<small>Không được chừa trống&nbsp<i class="fas fa-times"></i></small>');
                return false;
            }
            var repassword = $('#repassword').val();
            if (repassword == '') {
                $('#valid_repassword').html('<small>Không được chừa trống&nbsp<i class="fas fa-times"></i></small>');
                return false;
            } else {
                if (password != repassword) {
                    $('#valid_repassword').html('<small>Không trùng khớp&nbsp<i class="fas fa-times"></i></small>');
                    return false;
                }
            }
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
                    $('#valid_name').html('');
                    $('#valid_email').html('');
                    $('#valid_password').html('');
                    $('#valid_repassword').html('');
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save');
                }
            });
        });
        $('body').on('click', '.editAccount', function() {
            var acc_id = $(this).data('id');
            console.log('da nhan acc id = ', acc_id);
            $.ajax({
                data: $('#Form').serialize(),
                url: "{{ url('/admin-account') }}" + '/' + acc_id + '/edit',
                type: "get",
                dataType: 'json',
                success: function(data) {
                    console.log('Success:', data);
                    $('#modelHeading').html('Edit Account');
                    $('#saveBtn').html('Update');
                    $("#form-group-email").hide();
                    $("#form-group-password").hide();
                    $("#form-group-repassword").hide();
                    $('#username').val(data.name);
                    $('#email').val(data.email);
                    $('#password').val(data.password);
                    $('#repassword').val(data.password);
                    $("#level").val(data.isAdmin).change();
                    $("#user_id").val(acc_id);
                    $('#ajaxModel').modal('show');
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save');
                }
            });
        });

        $('body').on('click', '.deleteAccount', function() {
            var acc_id = $(this).data('id');
            console.log('da nhan acc id = ', acc_id);
            var result = confirm("Are You sure want to delete this account?");
            if (result) {
                $.ajax({
                    data: $('#Form').serialize(),
                    url: "{{ url('/admin-account') }}" + '/' + acc_id,
                    type: "DELETE",
                    dataType: 'json',
                    success: function(data) {
                        console.log('Success delete:', data);
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);

                    }
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
                    $.get("{{ url('/multidel-acc') }}" + '/' + allVals, function(data) {
                        alert(allVals.length + " entries are deleted");
                        table.draw();
                        console.log(data);
                    });
                }
            } else {
                alert("There aren't any entry, please choose.");
            }

        });


    });
</script>

@endsection
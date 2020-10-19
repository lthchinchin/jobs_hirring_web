

<title>Change Password</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!--    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> repeat sorting icon-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

<div class="modal fade" id="ajaxModel_myacc" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading_myacc">My Account</h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                    {{csrf_field()}}
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group" id="form-group-username">
                        <label for="name" class="col-sm-4 control-label">User Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter user name" value="" maxlength="50" required="" autocomplete="off">
                            <p id='valid_username' style='color: red;'></p>
                        </div>
                    </div>

                    <div class="form-group" id="form-group-password">
                        <label for="name" class="col-sm-4 control-label">Password</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password" name="password" value="" maxlength="50" required="" autocomplete="off">
                            <p id='valid_password' style='color: red;'></p>
                        </div>
                    </div>
                    <div class="form-group" id="form-group-newpassword">
                        <label for="name" class="col-sm-4 control-label">NewPassword</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="newpassword" name="newpassword" value="" maxlength="50" required="" autocomplete="off">
                            <p id='valid_newpassword' style='color: red;'></p>
                        </div>
                    </div>
                    <div class="form-group" id="form-group-renewpassword">
                        <label for="name" class="col-sm-4 control-label">ReNewPassword</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="renewpassword" name="renewpassword" value="" maxlength="50" required="" autocomplete="off">
                            <p id='valid_renewpassword' style='color: red;'></p>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-primary" id="saveNew">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>

    $('#ajaxModel_myacc').modal('show');
    $('#user_id').val(<?php echo Session('acc_id'); ?>);
    $('#username').val('<?php echo Session('acc_name'); ?>');



    $('#saveNew').click(function(e) {
        e.preventDefault();
        var username = $('#username').val();
        if (username == '') {
            $('#valid_username').html('<small>Không được chừa trống&nbsp<i class="fas fa-times"></i></small>');
            return false;
        }

        var password = $('#password').val();
        if (password == '') {
            $('#valid_password').html('<small>Không được chừa trống&nbsp<i class="fas fa-times"></i></small>');
            return false;
        }
        var newpassword = $('#newpassword').val();
        if (newpassword == '') {
            $('#valid_newpassword').html('<small>Không được chừa trống&nbsp<i class="fas fa-times"></i></small>');
            return false;
        }
        var renewpassword = $('#renewpassword').val();
        if (renewpassword == '') {
            $('#valid_renewpassword').html('<small>Không được chừa trống&nbsp<i class="fas fa-times"></i></small>');
            return false;
        } else {
            if (newpassword != renewpassword) {
                $('#valid_renewpassword').html('<small>Không trùng khớp&nbsp<i class="fas fa-times"></i></small>');
                return false;
            }
        }
        // $(this).html('Saving..');
        $.ajax({
            data: $('#Form').serialize(),
            url: "{{ url('/admin-account') }}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                $('#Form').trigger("reset");
                $('#ajaxModel_myacc').modal('hide');
                console.log('Success:', data);
                $('#saveBtn').html('Save');
                $('#valid_name').html('');
                $('#valid_password').html('');
                $('#valid_newpassword').html('');
                $('#valid_renewpassword').html('');
                alert(data.message);
                window.location.href='/fbscrape/topic';
            },
            error: function(data) {
                console.log('Error:', data);
                $('#saveBtn').html('Save');
            }
        });
    });
</script>

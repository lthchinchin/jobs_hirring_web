
<!DOCTYPE html>
<html>
<head>
    <title>Laravel 6.2 Ajax CRUD with DataTables Tutorial For Beginners - MyNotePaper.com</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!--    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> repeat sorting icon-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
<div class="container">
    <div class="text-center" style="margin: 20px 0px 20px 0px;">
        <a href="https://www.mynotepaper.com/" target="_blank"><img src="https://i.imgur.com/hHZjfUq.png"></a><br>
        <span class="text-secondary">Brand Control Table</span>
    </div>
    <div class="container-fluid">
        <div class="row">
            <h4 class="one">Brand</h4>
            <button class="btn btn-info ml-auto" id="createNewBook">Create Brand</button>
        </div>
    </div>
    <br>
    <table id="dataTable" class="table table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Brand Name</th>
            <th>Brand Desc</th>
            <th>Status</th>
            <th width="280px">Action</th>
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
                        <label for="name" class="col-sm-2 control-label">Brand Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="brandname" name="brandname" placeholder="Enter brand name"
                                   value="" maxlength="50" required="" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="status" name="status"
                                   placeholder="Enter status"
                                   value="" maxlength="50" required="" autocomplete="off">
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

</body>

<script type="text/javascript">
    $(function () {
        //ajax setup
        $.ajaxSetup({
            headers: {
//                jQuery add CSRF token to all $.post() requests' data

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // datatable
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('brandAjax') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},//khong can name:, 
                {data: 'brand_name', name: 'brand_name'},
                {data: 'brand_desc', name: 'brand_desc'},
                {data: 'brand_status', name: 'brand_status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // create new book new book_id
        $('#createNewBook').click(function () {
            $('#saveBtn').html("Create");
            $('#book_id').val('');
            $('#bookForm').trigger("reset");
            $('#modelHeading').html("Create New Book");
            $('#ajaxModel').modal('show');
        });

        // create or update book
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Saving..');

            $.ajax({
                data: $('#bookForm').serialize(),
                url: "{{ url('brandAjax') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#bookForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                    console.log('Success:', data);
                    $('#saveBtn').html('Save');
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save');
                }
            });
        });

        // edit book
        $('body').on('click', '.editBook', function () {
            var book_id = $(this).data('id');
            console.log('id:', book_id);
            //gui den va tra ve data
            $.get("{{ url('brandAjax') }}" + '/' + book_id + '/edit', function (data) {
                
                $('#modelHeading').html("Edit Book");
                $('#saveBtn').html('Update');
                $('#ajaxModel').modal('show');
                $('#book_id').val(data.brand_id);
                $('#brandname').val(data.brand_name);
                $('#status').val(data.brand_status);
                console.log('back:', data.brand_id);
                console.log('back:', data.brand_name);
                console.log('back:', data.brand_status);
            });
        });

        // delete book
        $('body').on('click', '.deleteBook', function () {
            var book_id = $(this).data("id"); //get id tren the <a
            confirm("Are You sure want to delete !");
            console.log('id:', book_id);
            $.ajax({
                type: "DELETE",
                url: "{{ url('brandAjax') }}" + '/' + book_id ,
                success: function (data) {
                    console.log('Success:', data);
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
            
        });
        
        
        

    });
</script>
</html>

    
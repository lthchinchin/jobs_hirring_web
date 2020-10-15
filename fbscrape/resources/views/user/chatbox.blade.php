@extends('welcome2')
@section('content')
<!-- @include('user.loadchat') -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<div class="container">
    <div style="text-align: center;">
        <h2>Day la khu vuc thi nghiem chat ajax</h2>
    </div>
    <div class="col">

    </div>
    <form id="formchat" method="post">
        {{csrf_field()}}
        <div class="row" style="margin-top: 50px;">
            <textarea id="mess" name="mess" placeholder="nhap tin nhan"></textarea>
            <button id="saveBtn" type="button" class="btn btn-primary" style="margin-left: 10px;">Send</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    // $.ajaxSetup({
    //     headers: {
    //         //jQuery add CSRF token to all $.post() requests' data
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });

    // $('#saveBtn').click(function() {
    //     console.log('da click')
    //     $('#mess').val('');
    // });
    
    // $.ajaxSetup({
    //     cache: false
    // });
    // Thiết lập thời gian thực vòng lặp 1 giây
    // setInterval(function() {
    //     console.log('run');
    //     $('.col').load('loadchat');
    // }, 1000);
    $('.col').load('loadchat');
    $('#saveBtn').click(function(e) {
        e.preventDefault();
        // $(this).html('Saving..');
        $.ajax({
            data: $('#formchat').serialize(),
            url: "{{ url('/chatting') }}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                console.log('Success:', data);
                $('#mess').val('');
                $('.col').load('loadchat');
            },
            error: function(data) {
                console.log('Error:', data);
                // $('#saveBtn').html('Save');
            }
        });
    });
</script>
@endsection
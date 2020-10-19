@extends('welcome2')
@section('content')
<?php

use \Illuminate\Support\Facades\Session;
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<style>
    /* box model hacks not catered for in the demo */
    /* global reset for demo purposes only - use a proper reset in a real page*/
    * {
        margin: 0;
        padding: 0
    }

    p {
        margin: 0 0 .5em 0
    }

    h1 {
        margin: 1em 0;
        text-align: center
    }

    #catlist {
        /* border: 1px dashed #ccc; */
        border-bottom: none;
        width: 660px;
        margin: 10px auto;
    }

    #catlist dl {
        width: 640px;
        margin: 0 auto;
        border-bottom: 1px dashed #ccc;
        padding: 10px;
        overflow: hidden;
        background: #f2f2f2;
    }

    #catlist dd {
        overflow: auto
    }

    #catlist dt strong {
        float: right;
        padding: 0 0 0 20px;
    }

    #catlist dt img {
        float: left;
        margin: 0 10px 0 0;
        border: 1px solid #000;
    }

    * html dd {
        height: 1%
    }

    /* 3px jog*/
</style>

<div class="container text-center">
    <h5>Đây là khu vực topic</h5>
</div>
<div class="container-fluid">
    <div style="text-align: center;margin-top: 50px;">
        <div class="modal fade" id="ajaxModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading">Create Topic</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form" method="post" class="form-horizontal">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name" class="col-sm-4 control-label">
                                    <h6>Title Topic</h6>
                                </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="title_topic" name="topic_title" placeholder="Nhập tiêu đề topic.." required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">
                                    <h6>Desc</h6>
                                </label>
                                <div class="col-sm-12">
                                    <textarea id="mess" name="topic_content" placeholder="Mô tả rõ về điều bạn nghĩ.." type="text" class="form-control" rows="3" autocomplete="off"></textarea>
                                </div>
                            </div>
                            <div>
                                <button id="saveBtn" type="button" style="text-align: center;" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <?php if (Session('acc_level') != -1 && Session('acc_level') != -3) { ?>
                <div class="row">
                    <textarea placeholder="Bạn đang nghĩ gì?" style="width: 490px;"></textarea>
                    <button class="btn btn-primary" style="margin-left: 10px;" id="showmodal" type="button">Create</button>
                </div>
            <?php } ?>
        </div>
    </div>
    <div id="catlist">
        <div id="topics">
        </div>
    </div>

    <!-- <form id="form" method="post">
            {{csrf_field()}}
            <textarea id="mess" name="topic_content" placeholder="Bạn đang nghĩ gì?" style="width: 490px;"></textarea>
            <div><button id="saveBtn" type="button" class="btn btn-primary" style="margin-left: 430px;">Send</button></div>
        </form> -->
</div>
<script type="text/javascript">
    // topic detail
    $('#topics').on('click', '.detailtopic', function() {
        var topic_id = $(this).data('id');
        // alert('da click ');
        console.log("da nhan :", topic_id);
        var loadlink = 'topic-' + topic_id;
        $('#topics').load(loadlink);
        console.log("da load den topic :", topic_id);

    });

    $('#topics').on('click', '#back', function() {
        console.log("pressed back");
        $('#topics').load('topic-load');
    });

    //like
    $('#topics').on('click', '#favourite', function() {
        var topic_id = $(this).data('id');
        var liker_id = <?php echo Session('acc_id'); ?>;
        console.log("liked topic :" + topic_id + " liker is : " + liker_id);

        $.ajax({
            data: $('#form').serialize(),
            url: "{{ url('/topic-like') }}" + '/' + topic_id + '/' + liker_id,
            type: "get",
            dataType: 'json',
            success: function(data) {
                console.log('Success:', data);
                // alert("Thành công!")
                $('#topics').load('topic-load');
            },
            error: function(data) {
                alert("Không thành công!")
                console.log('Error:', data);
            }
        });
        // $('#topics').load('topic-load');
    });


    $('#showmodal').click(function() {
        console.log("200");
        $('#ajaxModel').modal('show');
    });

    $('#topics').load('topic-load');
    //create topic
    $('#saveBtn').click(function(e) {
        var title_topic = $('#title_topic').val();
        var content_topic = $('#mess').val();

        // Kiểm tra dữ liệu có null hay không
        if ($.trim(title_topic) == '') {
            alert('Bạn chưa nhập title');
            return false;
        }
        if ($.trim(content_topic) == '') {
            alert('Bạn chưa nhập description topic');
            return false;
        }


        // e.preventDefault(); // Now nothing will happen ngăn chặn submit form o day dung button nen k can 
        // $(this).html('Saving..');
        $.ajax({
            data: $('#form').serialize(),
            url: "{{ url('/topic-create') }}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                console.log('Success:', data);
                $('#ajaxModel').modal('hide');
                $('#form').trigger("reset");
                alert("Thành công!")
                $('#topics').load('topic-load');
            },
            error: function(data) {
                alert("Không thành công!")
                console.log('Error:', data);
            }
        });
    });

    $('#form').keydown(function(e) {
        if (e.keyCode === 13) { // If Enter key pressed
            $('#saveBtn').click();
        }
    });

    //create comment

    $('#topics').on('click', '#btncmt', function() {
        // Kiểm tra có nhập hay chưa
        console.log('da nhan nut');
        var coment = $('#cmt').val();
        if ($.trim(coment) == '') {
            alert('Bạn chưa nhập bình luận');
            return false;
        }
        // e.preventDefault(); // Now nothing will happen ngăn chặn submit form o day dung button nen k can 
        // $(this).html('Saving..');
        $.ajax({
            data: $('#cmtform').serialize(),
            url: "{{ url('/topic-cmt') }}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                console.log('Success:', data);
                $('#ajaxModel').modal('hide');
                $('#form').trigger("reset");
                // alert("Thành công!")
                topic_id = $('#tp_id').val();
                var loadlink = 'topic-' + topic_id;
                $('#topics').load(loadlink);
            },
            error: function(data) {
                alert("Không thành công!")
                console.log('Error:', data);
            }
        });
    });

    // is admin del topic or owner topic del their topic
    $('#topics').on('click', '#del', function() {
        var topic_id = $(this).data('id');
        var owner_id = $(this).data('acc');
        var acc_level = <?php echo Session('acc_level'); ?>;
        console.log("deleted topic :" + topic_id + " owner : " + owner_id);
        var result = confirm("Are You sure want to delete this topic?");
        if (result) {
            $.ajax({
                data: $('#form').serialize(),
                url: "{{ url('/topic-del') }}" + '/' + topic_id + '/' + owner_id,
                type: "get",
                dataType: 'json',
                success: function(data) {
                    console.log('Success:', data);
                    // alert("Thành công!")
                    $('#topics').load('topic-load');
                },
                error: function(data) {
                    alert("Không thành công!")
                    console.log('Error:', data);
                }
            });
        }
        // $('#topics').load('topic-load');
    });

    // del cmt : owner cmt del or owner post del
    $('#topics').on('click', '#delcmt', function() {
        var cmt_id = $(this).data('id');
        var acc_del = $(this).data('acc');
        console.log('xoa cmt : ' + cmt_id + " | id acc xoa : " + acc_del);
        var result = confirm("Are You sure want to delete this cmt?");
        if (result) {
            $.ajax({
                data: $('#form').serialize(),
                url: "{{ url('/cmt-del') }}" + '/' + cmt_id + '/' + acc_del,
                type: "get",
                dataType: 'json',
                success: function(data) {
                    console.log('Success:', data);
                    // alert(data.message);
                    topic_id = $('#tp_id').val();
                    var loadlink = 'topic-' + topic_id;
                    $('#topics').load(loadlink);
                },
                error: function(data) {
                    alert("Không thành công!")
                    console.log('Error:', data);
                }
            });
        }
    });

    //edit

    $('#topics').on('click', '#edit', function() {
        var topic_id = $(this).data('id');
        // var owner_id = $(this).data('acc');
        // var acc_level = <?php echo Session('acc_level'); ?>;
        // console.log("deleted topic :" + topic_id + " owner : " + owner_id);

        $.ajax({
            data: $('#form').serialize(),
            url: "{{ url('/topic-edit') }}" + '/' + topic_id,
            type: "get",
            dataType: 'json',
            success: function(data) {
                console.log('Success:', data);
                console.log('title topic:', data.title_topic);
                console.log('content topic:', data.content_topic);
                $('#ajaxModel').modal('show');
                $('#title_topic').val(data.title_topic);
                $('#mess').val(data.content_topic);
                $('#saveBtn').html('Update');
                $('#modelHeading').html('Update Topic');
                var topicid = "<input type='hidden' id='tp_id' name='id_topic' value='" + topic_id + "'></input>";
                $("#form").append(topicid);

            },
            error: function(data) {
                alert("Update Không thành công!")
                console.log('Error:', data);
            }
        });

    });
</script>

@endsection
<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class topicController extends Controller
{
    public function index()
    {
        if (Session('acc_id') != null) {
            return view('topic');
        } else {
            return Redirect::to('/login');
        }
    }

    public function create(Request $request)
    {
        if (isset($request->id_topic)) {
            DB::table('tbl_topic')
                ->where('id', $request->id_topic)
                ->update([
                    'title_topic' => $request->topic_title,
                    'content_topic' => $request->topic_content
                ]);
            $response = [
                'success' => true,
                'message' => 'update successfully.',
            ];
        } else {
            DB::table('tbl_topic')->insert(
                [
                    'content_topic' => $request->topic_content,
                    'title_topic' => $request->topic_title,
                    'id_user_creator' => Session('acc_id')
                ]
            );
            // return response
            $response = [
                'success' => true,
                'message' => 'insert successfully.',
            ];
        }

        return response()->json($response, 200);
    }
    public function deltopic($id, $acc)
    {
        if (Session('acc_level') == 1 || Session('acc_id') == $acc) {
            DB::table('tbl_topic')->where('id', '=', $id)->delete();
            $response = [
                'success' => true,
                'message' => 'delete successfully.',
            ];
            return response()->json($response, 200);
        } else {
            return Redirect::to('/topic');
        }
    }

    public function edittopic($id)
    {

        $topic = DB::table('tbl_topic')->where('id', '=', $id)->first();
        return response()->json($topic);
    }


    public function like($id_topic, $id_liker)
    {
        $check = DB::table('tbl_likes')->where('id_topic', '=', $id_topic)->where('id_liker', '=', $id_liker)->count();
        // dd($check);
        if ($check == 0) {
            DB::table('tbl_likes')->insert(
                [
                    'id_topic' => $id_topic,
                    'id_liker' => $id_liker
                ]
            );
            $response = [
                'success' => true,
                'message' => 'insert successfully.',
            ];
        } else {
            DB::table('tbl_likes')->where('id_topic', '=', $id_topic)->where('id_liker', '=', $id_liker)->delete();
            $response = [
                'success' => true,
                'message' => 'delete successfully.',
            ];
        }
        // return response

        return response()->json($response, 200);
    }

    public function comment(Request $request)
    {
        DB::table('tbl_comments')->insert(
            [
                'id_topic' => $request->id_topic,
                'id_user' => $request->id_acc,
                'comment' => $request->comment
            ]
        );
        // return response
        $response = [
            'success' => true,
            'message' => 'insert successfully.',
        ];
        return response()->json($response, 200);
    }

    public function load()
    {
        $topics = DB::table('tbl_topic')->select(
            'tbl_topic.id',
            'title_topic',
            'users.id as id_acc',
            'name',
            'content_topic',
            'daytime',
            DB::raw('count(tbl_likes.id_liker) as likes')
        )
            ->leftjoin('tbl_likes', 'tbl_likes.id_topic', '=', 'tbl_topic.id')
            ->join('users', 'users.id', '=', 'tbl_topic.id_user_creator')
            ->groupBy('tbl_topic.id', 'title_topic', 'users.id', 'id_acc', 'name', 'content_topic', 'daytime')->orderBy('tbl_topic.id', 'desc')->get();

        // $topics = DB::table('tbl_topic')->select(
        //     'tbl_topic.id',
        //     'id_user_creator',
        //     'title_topic',
        //     'content_topic',
        //     'favourite',
        //     'daytime',
        //     DB::raw('count(tbl_likes.id_liker) as likes')
        // )->leftjoin('tbl_likes', 'tbl_likes.id_topic', '=', 'tbl_topic.id')
        //     ->groupBy('tbl_topic.id', 'id_user_creator', 'title_topic', 'content_topic', 'favourite', 'daytime',)->orderBy('tbl_topic.id', 'desc')->get();
        // dd($topics);

        $acc_id = Session('acc_id');
        // dd($acc_id);
        foreach ($topics as $topic) {
            // echo "<div class='row'><h6 style='color:blue;'>$topic->name :</h6><h6>&nbsp;$topic->content_topic</h6><div style='color:blue;'>&nbsp;&nbsp;&nbsp;Lúc: $topic->daytime</div></div>";
            echo "<dl><dt><img src='http://placehold.it/300x200' alt='user avatar' height='60px' width='60px' />
            <a class='detailtopic' data-id=$topic->id >$topic->title_topic</a></dt>
            <dd>
                <p>$topic->content_topic</p>";
            if ($topic->id_acc == $acc_id) {
                if ($topic->id_acc == 1) {
                    echo "<small style='font-style: italic;color: #ff6a00'>$topic->name</small><small style='font-weight: bold;color: #00eba0'>-QTV</small>";
                } else {
                    echo "<small style='font-style: italic;color: #ff6a00'>$topic->name</small>";
                }

                echo "<small style='color:blue;'><$topic->daytime</small></dd>";
                echo "<button id='favourite' data-id=$topic->id data-acc=$topic->id_acc style='float: left;' class='btn btn-outline-danger btn-sm'><i class='far fa-heart'></i></button>
                <button id='del' data-id=$topic->id data-acc=$topic->id_acc style='float: left; margin-left: 10px' class='btn btn-danger btn-sm'><i class='far fa-trash-alt'></i></button>
                <button id='edit' data-id=$topic->id data-acc=$topic->id_acc style='float: left; margin-left: 10px' class='btn btn-primary btn-sm'><i class='far fa-edit'></i></button>";
            } else {
                echo "<small style='font-style: italic;'>$topic->name</small>";
                echo "<small style='color:blue;'><$topic->daytime</small></dd>";
                echo "<button id='favourite' data-id=$topic->id style='float: left;' class='btn btn-outline-danger btn-sm'><i class='far fa-heart'></i></button>";
            }
            // && Session('acc_level') != 1
            if (Session('acc_level') == 1) {
                if ($topic->id_acc != Session('acc_id'))
                    echo "<button id='del' data-id=$topic->id data-acc=$topic->id_acc style='float: left; margin-left: 10px' class='btn btn-danger btn-sm'><i class='far fa-trash-alt'></i></button>";
            }
            echo "<h6 style='float: right;color: #ff4845;'>Yêu thích: $topic->likes</h6></dl>";
        }
    }

    public function detail($id)
    {
        $acc_id = Session('acc_id');
        if (Session('acc_id') == null) {
            return Redirect::to('/login');
        } else {

            $topic = DB::table('tbl_topic')->select(
                'tbl_topic.id',
                'title_topic',
                'name',
                'content_topic',
                'daytime',
                DB::raw('count(tbl_likes.id_liker) as likes')
            )
                ->leftjoin('tbl_likes', 'tbl_likes.id_topic', '=', 'tbl_topic.id')
                ->join('users', 'users.id', '=', 'tbl_topic.id_user_creator')
                ->where('tbl_topic.id', '=', $id)
                ->groupBy('tbl_topic.id', 'title_topic', 'name', 'content_topic', 'daytime')->orderBy('tbl_topic.id', 'desc')->get();
            // dd($topic);
            $comments = DB::table('tbl_comments')
                ->select('comment', 'daytime_cmt', 'name')
                ->join('users', 'users.id', '=', 'tbl_comments.id_user')
                ->where('id_topic', '=', $id)
                ->get();
            // dd($comments);


            foreach ($topic as $topic) {
                // echo "<div class='row'><h6 style='color:blue;'>$topic->name :</h6><h6>&nbsp;$topic->content_topic</h6><div style='color:blue;'>&nbsp;&nbsp;&nbsp;Lúc: $topic->daytime</div></div>";
                echo "<dl><dt><img src='http://placehold.it/300x200' alt='user avatar' height='60px' width='60px' /><strong>$topic->name</strong>
            <h4><a>$topic->title_topic</a></h4></dt>
            <dd>
                <p>$topic->content_topic</p>
                <small style='color:blue;'>>$topic->daytime</small>
                <button id='back' style='float: right;' class='btn btn-warning btn-sm'>Quay lại</button>
            </dd>
        </dl>";
            }

            foreach ($comments as $comment) {
                echo "<dl>
                <h4><a style='color: blue;'>$comment->name : </a></h4><div style='margin-left: 10px'><h6 >$comment->comment</h6><small style='color:blue'>$comment->daytime_cmt</small></div>
        </dl>";
            }



            echo "<div class='col-sm-12' style='margin-top: 20px'>
                <form id='cmtform' method='post'>";
            echo csrf_field();
            echo "<input type='hidden' id='tp_id' name='id_topic' value='$id'></input>
                <input type='hidden' name='id_acc' value='$acc_id'></input>
                <textarea id='cmt' name='comment' placeholder='Bình luận..' type='text' class='form-control' rows='3' autocomplete='off'></textarea>
                <button type='button' id='btncmt' style='float: right;margin-top: 10px' class='btn btn-primary'>Gửi</button>
                </div></form>";
        }
    }
}

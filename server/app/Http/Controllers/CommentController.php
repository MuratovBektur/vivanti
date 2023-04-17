<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comment;
use App\Models\CommentLike;

class CommentController extends Controller
{
    public function add(Request $request)
    {
        $comment = new Comment;
        $comment->post_id = $request->input('post_id');
        $comment->parent_id = $request->input('parent_id');
        $comment->user_id = $request->input('user_id');
        $comment->content = $request->input('content');
        $comment->is_it_reply_to_comment = $request->input('is_it_reply_to_comment');
        $comment->save();
        return $comment;
    }
    public function addLike(Request $request)
    {

        $comment_id = $request->input('comment_id');
        $user_id = $request->input('user_id');

        $comment_like = CommentLike::where('comment_id', '=', $comment_id)
            ->where('user_id', '=', $user_id)
            ->first();

        if ($comment_like) {
            return [
                'msg' => 'added before'
            ];
        }
        $comment = Comment::find($comment_id);
        $comment->like_count++;
        $comment->save();

        $new_comment_like = new CommentLike;
        $new_comment_like->comment_id = $comment_id;
        $new_comment_like->user_id = $user_id;
        $new_comment_like->save();
        return $new_comment_like;
    }
    public function removeLike(Request $request)
    {

        $comment_id = $request->input('comment_id');
        $user_id = $request->input('user_id');

        $comment_like = CommentLike::where('comment_id', '=', $comment_id)
            ->where('user_id', '=', $user_id)
            ->first();

        if (!$comment_like) {
            return [
                'msg' => 'doesn\'t added before'
            ];
        }

        $comment = Comment::find($comment_id);
        $comment->like_count--;
        $comment->save();

        $comment_like->delete();

        return [
            'msg' => 'removed record'
        ];
    }
}
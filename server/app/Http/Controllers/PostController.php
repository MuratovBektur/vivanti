<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

class PostController extends Controller
{
    public function getAll()
    {
        $posts = Post::select('id', 'title')
            ->orderBy('created_at', 'DESC')
            ->get();
        return $posts;
    }
    public function getId(int $post_id, int|null $user_id)
    {
        $posts = Post::with([
            // на первом уровне вложености
            // показываем только комменты
            // которые не имеют родителя
            'comments' => function ($query) {
                $query
                    ->orderBy('id', 'asc')
                    ->whereNull('parent_id');
            },
            // на втором уровне вложености
            // отсеиваются все комменты
            // которые не имеют родителя
            'comments.children' => function ($query) {
                $query
                    ->orderBy('id', 'asc');
            },
            'comments.children.user',
            'comments.user',
            // получаем инфо только о лайках
            // юзера который отправил запрос
            'comments.comments_likes' => function ($query) use ($user_id) {
                $query
                    ->where('user_id', '=', $user_id);
            },
            // получаем инфо только о лайках
            // юзера который отправил запрос
            'comments.children.comments_likes' => function ($query) use ($user_id) {
                $query
                    ->where('user_id', '=', $user_id);
            },
        ])->find($post_id);

        return $posts;
    }

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Post;
use App\Models\User;
use App\Models\CommentLike;

class Comment extends Model
{
    use HasFactory;

    protected $content = 'string';
    protected $user_fullname = 'string';
    protected $is_it_reply_to_comment = 'boolean';
    protected $like_count = 'number';

    // для соединения таблицы на себя
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    // для соединения таблицы на себя
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments_likes()
    {
        return $this->hasMany(CommentLike::class);
    }
}
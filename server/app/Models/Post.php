<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Comment;

class Post extends Model
{
    use HasFactory;
    protected $title = 'string';

    protected $content = 'string';

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
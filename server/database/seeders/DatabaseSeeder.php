<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public $fullnames = [
        'Noelle Fernandez',
        'Atticus Stephens',
        'Renee Allison',
        'Nora Franco',
        'Bridget Ramirez',
        'Angelica Dougherty',
        'Kelsey Aguirre',
        'Kyleigh Bray',
        'Elisha Larson',
        'Carl Stewart',
        'Mareli Pena',
        'Ashlee Ingram',
    ];
    public function run(): void
    {
        $this->addUsers();
        $this->addPostsAndComments();
    }

    public function addPostsAndComments(): void
    {

        $comment_id = 1;
        $previus_user_id = null;
        $fullnames = $this->fullnames;

        for ($post_id = 1; $post_id <= 10; $post_id++) {
            $post = new Post;
            $post->title = "Post $post_id";
            $post->content = "Content $post_id
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt blanditiis, eveniet magni
            hic officiis odio soluta molestiae, enim exercitationem, provident tempore quidem laboriosam
            omnis cum! Possimus vel suscipit dignissimos ea accusamus! Adipisci sed laboriosam sunt
            asperiores ea, ipsam unde delectus ipsum quam mollitia magnam nobis, ad modi fuga libero vitae
            aperiam ipsa cupiditate cumque odit error tempore? Earum aperiam non cupiditate nihil saepe
            sint magnam animi corporis praesentium, nemo expedita aliquid necessitatibus voluptate, quidem
            aut, sunt architecto! Maiores dolor soluta quisquam sit libero enim quo sed praesentium quos
            commodi atque, est, minus nulla nam provident, quae dolores. Dolorum fugiat, nostrum
            blanditiis ex, recusandae at, eligendi commodi cum illo similique dolores. Officiis, vero.
            Odit quisquam maiores ducimus doloremque qui! Doloremque dolorem autem error saepe.
            ";
            $post->save();

            for ($i = 1; $i <= 4; $i++, $comment_id++) {
                $comment = new Comment;
                $comment->post_id = $post_id;
                $parent_id = null;
                $user_id = rand(1, count($fullnames));
                $prev_text = '';

                if ($i === 3) {
                    $previus_user_id = $user_id;
                    $parent_id = $comment_id - 1;
                } else if ($i === 4) {
                    $previus_fullname = $fullnames[$previus_user_id - 1];
                    $prev_text = "<span class='username'>$previus_fullname</span>,";
                    $parent_id = $comment_id - 2;
                }

                $comment->is_it_reply_to_comment = (boolean) $prev_text;
                $comment->user_id = $user_id;
                $comment->parent_id = $parent_id;
                $comment->content = "$prev_text content $comment_id Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque maiores illum iusto corrupti
                dolores explicabo vel perspiciatis nulla nihil modi molestias hic ex, id rem fugiat!
                Necessitatibus earum, quia facere sed expedita omnis.";

                $comment->save();
            }
        }
    }

    public function addUsers(): void
    {

        for ($user_id = 1; $user_id <= 12; $user_id++) {
            $fullname = $this->fullnames[$user_id - 1];
            $user = new User;
            $user->fullname = $fullname;
            $user->email = $fullname . "@gmail.com";
            $user->password = Hash::make($fullname . "password");

            $user->save();
        }
    }
}
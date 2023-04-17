<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments_likes', function (Blueprint $table) {
            $user_id_label = 'user_id';
            $comment_id_label = 'comment_id';


            $table->id();

            $table->unsignedBigInteger($user_id_label)->nullable();
            $table
                ->foreign($user_id_label)
                ->references('id')
                ->on('users');

            $table->unsignedBigInteger($comment_id_label)->nullable();
            $table
                ->foreign($comment_id_label)
                ->references('id')
                ->on('comments');

            $table->integer('like_count')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments_likes');
    }
};
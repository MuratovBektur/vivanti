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
        Schema::create('comments', function (Blueprint $table) {
            $parent_id_label = 'parent_id';
            $post_id_label = 'post_id';
            $user_id_label = 'user_id';

            $table->id();

            $table->unsignedBigInteger($parent_id_label)->nullable();
            $table
                ->foreign($parent_id_label)
                ->references('id')
                ->on('comments');

            $table->unsignedBigInteger($post_id_label);
            $table
                ->foreign($post_id_label)
                ->references('id')
                ->on('posts');

            $table->unsignedBigInteger($user_id_label);
            $table
                ->foreign($user_id_label)
                ->references('id')
                ->on('users');

            $table->text('content');
            $table->boolean('is_it_reply_to_comment')->default(false);
            $table->integer('like_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
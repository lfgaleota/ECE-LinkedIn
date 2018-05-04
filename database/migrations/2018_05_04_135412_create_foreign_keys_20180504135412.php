<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignKeys20180504135412 extends Migration {

    public function up()
    {
	    $this->down();
	    Schema::table('users', function(Blueprint $table) {
		    $table->foreign('photo_id')->references('post_id')->on('posts')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('users', function(Blueprint $table) {
		    $table->foreign('cover_id')->references('post_id')->on('posts')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('posts', function(Blueprint $table) {
		    $table->foreign('author_id')->references('user_id')->on('users')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('posts', function(Blueprint $table) {
		    $table->foreign('event_id')->references('event_id')->on('events')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('events', function(Blueprint $table) {
		    $table->foreign('author_id')->references('user_id')->on('users')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('comments', function(Blueprint $table) {
		    $table->foreign('post_id')->references('post_id')->on('posts')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('comments', function(Blueprint $table) {
		    $table->foreign('author_id')->references('user_id')->on('users')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('conversations', function(Blueprint $table) {
		    $table->foreign('message_id')->references('message_id')->on('messages')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('conversation_members', function(Blueprint $table) {
		    $table->foreign('conversation_id')->references('conversation_id')->on('conversations')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('conversation_members', function(Blueprint $table) {
		    $table->foreign('user_id')->references('user_id')->on('users')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('messages', function(Blueprint $table) {
		    $table->foreign('author_id')->references('user_id')->on('users')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('entities', function(Blueprint $table) {
		    $table->foreign('author_id')->references('user_id')->on('users')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('friendships', function(Blueprint $table) {
		    $table->foreign('friend1_id')->references('user_id')->on('users')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('friendships', function(Blueprint $table) {
		    $table->foreign('friend2_id')->references('user_id')->on('users')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('friend_requests', function(Blueprint $table) {
		    $table->foreign('requester_id')->references('user_id')->on('users')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('friend_requests', function(Blueprint $table) {
		    $table->foreign('invited_id')->references('user_id')->on('users')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('job_offers', function(Blueprint $table) {
		    $table->foreign('author_id')->references('user_id')->on('users')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('job_offers', function(Blueprint $table) {
		    $table->foreign('entity_id')->references('entity_id')->on('entities')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('reactions', function(Blueprint $table) {
		    $table->foreign('post_id')->references('post_id')->on('posts')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('reactions', function(Blueprint $table) {
		    $table->foreign('comment_id')->references('comment_id')->on('comments')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('reactions', function(Blueprint $table) {
		    $table->foreign('author_id')->references('user_id')->on('users')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('post_visibilities', function(Blueprint $table) {
		    $table->foreign('post_id')->references('post_id')->on('posts')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('post_visibilities', function(Blueprint $table) {
		    $table->foreign('user_id')->references('user_id')->on('users')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('sub_posts', function(Blueprint $table) {
		    $table->foreign('parent_post_id')->references('post_id')->on('posts')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
	    Schema::table('sub_posts', function(Blueprint $table) {
		    $table->foreign('child_post_id')->references('post_id')->on('posts')
			    ->onDelete('cascade')
			    ->onUpdate('cascade');
	    });
        Schema::table('networks', function(Blueprint $table) {
            $table->foreign('user1_id')->references('user_id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('networks', function(Blueprint $table) {
            $table->foreign('user2_id')->references('user_id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
	    Schema::table('users', function(Blueprint $table) {
		    $table->dropForeign('users_photo_id_foreign');
	    });
	    Schema::table('users', function(Blueprint $table) {
		    $table->dropForeign('users_cover_id_foreign');
	    });
	    Schema::table('posts', function(Blueprint $table) {
		    $table->dropForeign('posts_author_id_foreign');
	    });
	    Schema::table('posts', function(Blueprint $table) {
		    $table->dropForeign('posts_event_id_foreign');
	    });
	    Schema::table('events', function(Blueprint $table) {
		    $table->dropForeign('events_author_id_foreign');
	    });
	    Schema::table('comments', function(Blueprint $table) {
		    $table->dropForeign('comments_post_id_foreign');
	    });
	    Schema::table('comments', function(Blueprint $table) {
		    $table->dropForeign('comments_author_id_foreign');
	    });
	    Schema::table('conversations', function(Blueprint $table) {
		    $table->dropForeign('conversations_message_id_foreign');
	    });
	    Schema::table('conversation_members', function(Blueprint $table) {
		    $table->dropForeign('conversation_members_conversation_id_foreign');
	    });
	    Schema::table('conversation_members', function(Blueprint $table) {
		    $table->dropForeign('conversation_members_user_id_foreign');
	    });
	    Schema::table('messages', function(Blueprint $table) {
		    $table->dropForeign('messages_author_id_foreign');
	    });
	    Schema::table('entities', function(Blueprint $table) {
		    $table->dropForeign('entities_author_id_foreign');
	    });
	    Schema::table('friendships', function(Blueprint $table) {
		    $table->dropForeign('friendships_friend1_id_foreign');
	    });
	    Schema::table('friendships', function(Blueprint $table) {
		    $table->dropForeign('friendships_friend2_id_foreign');
	    });
	    Schema::table('friend_requests', function(Blueprint $table) {
		    $table->dropForeign('friend_requests_requester_id_foreign');
	    });
	    Schema::table('friend_requests', function(Blueprint $table) {
		    $table->dropForeign('friend_requests_invited_id_foreign');
	    });
	    Schema::table('job_offers', function(Blueprint $table) {
		    $table->dropForeign('job_offers_author_id_foreign');
	    });
	    Schema::table('job_offers', function(Blueprint $table) {
		    $table->dropForeign('job_offers_entity_id_foreign');
	    });
	    Schema::table('reactions', function(Blueprint $table) {
		    $table->dropForeign('reactions_post_id_foreign');
	    });
	    Schema::table('reactions', function(Blueprint $table) {
		    $table->dropForeign('reactions_comment_id_foreign');
	    });
	    Schema::table('reactions', function(Blueprint $table) {
		    $table->dropForeign('reactions_author_id_foreign');
	    });
	    Schema::table('post_visibilities', function(Blueprint $table) {
		    $table->dropForeign('post_visibilities_post_id_foreign');
	    });
	    Schema::table('post_visibilities', function(Blueprint $table) {
		    $table->dropForeign('post_visibilities_user_id_foreign');
	    });
	    Schema::table('sub_posts', function(Blueprint $table) {
		    $table->dropForeign('sub_posts_parent_post_id_foreign');
	    });
	    Schema::table('sub_posts', function(Blueprint $table) {
		    $table->dropForeign('sub_posts_child_post_id_foreign');
	    });
	    Schema::table('networks', function(Blueprint $table) {
		    $table->dropForeign('networks_user1_id_foreign');
	    });
	    Schema::table('networks', function(Blueprint $table) {
		    $table->dropForeign('networks_user2_id_foreign');
	    });
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('photo_id')->references('post_id')->on('posts')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('cover_id')->references('post_id')->on('posts')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('posts', function(Blueprint $table) {
			$table->foreign('author_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('posts', function(Blueprint $table) {
			$table->foreign('event_id')->references('event_id')->on('events')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('events', function(Blueprint $table) {
			$table->foreign('author_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('comments', function(Blueprint $table) {
			$table->foreign('post_id')->references('post_id')->on('posts')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('comments', function(Blueprint $table) {
			$table->foreign('author_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('conversations', function(Blueprint $table) {
			$table->foreign('message_id')->references('message_id')->on('messages')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('conversation_members', function(Blueprint $table) {
			$table->foreign('conversation_id')->references('conversation_id')->on('conversations')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('conversation_members', function(Blueprint $table) {
			$table->foreign('user_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('messages', function(Blueprint $table) {
			$table->foreign('author_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('entities', function(Blueprint $table) {
			$table->foreign('author_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('friendships', function(Blueprint $table) {
			$table->foreign('friend1_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('friendships', function(Blueprint $table) {
			$table->foreign('friend2_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('friend_requests', function(Blueprint $table) {
			$table->foreign('requester_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('friend_requests', function(Blueprint $table) {
			$table->foreign('invited_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('job_offers', function(Blueprint $table) {
			$table->foreign('author_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('job_offers', function(Blueprint $table) {
			$table->foreign('entity_id')->references('entity_id')->on('entities')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('reactions', function(Blueprint $table) {
			$table->foreign('post_id')->references('post_id')->on('posts')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('reactions', function(Blueprint $table) {
			$table->foreign('comment_id')->references('comment_id')->on('comments')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('reactions', function(Blueprint $table) {
			$table->foreign('author_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('post_visibilities', function(Blueprint $table) {
			$table->foreign('post_id')->references('post_id')->on('posts')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('post_visibilities', function(Blueprint $table) {
			$table->foreign('user_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('sub_posts', function(Blueprint $table) {
			$table->foreign('parent_post_id')->references('post_id')->on('posts')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('sub_posts', function(Blueprint $table) {
			$table->foreign('child_post_id')->references('post_id')->on('posts')
						->onDelete('restrict')
						->onUpdate('restrict');
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
	}
}
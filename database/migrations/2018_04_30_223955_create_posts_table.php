<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	public function up()
	{
		Schema::create('posts', function(Blueprint $table) {
			$table->bigInteger('post_id')->primary()->unsigned();
			$table->integer('author_id')->unsigned()->index();
			$table->bigInteger('event_id')->unsigned()->nullable()->index();
			$table->enum('type', array('POST', 'SHARE', 'IMAGE', 'VIDEO', 'EVENT'))->index();
			$table->string('description');
			$table->string('location')->nullable();
			$table->enum('mood', array('HAPPY', 'MAD', 'SAD', 'LAUGHING', 'HUNGRY', 'EXCITED', 'ACTIVITY_RUNNING', 'ACTIVITY_EATING', 'ACTIVITY_TRAVELING', 'ACTIVITY_WATCHING'))->nullable();
			$table->string('image_url')->nullable();
			$table->string('video_url')->nullable();
            $table->enum('visibility', array('PUBLIC', 'NETWORKMEMBERS', 'FRIENDS', 'RESTRICTED'));
			$table->timestamp('updated_at')->useCurrent();
            			$table->timestamp('created_at')->useCurrent();;
		});
	}

	public function down()
	{
		Schema::drop('posts');
	}
}
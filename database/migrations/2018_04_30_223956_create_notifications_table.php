<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->bigInteger('notification_id')->primary()->unsigned();
			$table->integer('user_id')->unsigned();
			$table->enum('type', array('REACTION', 'COMMENT', 'FRIEND_REQUEST'));
			$table->boolean('read')->default(0);
			$table->bigInteger('reaction_id')->unsigned()->nullable()->index();
			$table->bigInteger('comment_id')->unsigned()->nullable()->index();
			$table->bigInteger('friend_request_id')->unsigned()->nullable()->index();
            $table->timestamp('updated_at')->useCurrent();
                        $table->timestamp('created_at')->useCurrent();;
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}
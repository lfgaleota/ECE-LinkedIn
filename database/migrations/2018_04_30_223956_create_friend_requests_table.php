<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFriendRequestsTable extends Migration {

	public function up()
	{
		Schema::create('friend_requests', function(Blueprint $table) {
			$table->integer('requester_id')->unsigned();
			$table->integer('invited_id')->unsigned();
			$table->timestamp('updated_at')->useCurrent();
            			$table->timestamp('created_at')->useCurrent();;

			$table->primary(['requester_id', 'invited_id']);
		});
	}

	public function down()
	{
		Schema::drop('friend_requests');
	}
}
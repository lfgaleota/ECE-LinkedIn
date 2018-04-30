<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConversationsTable extends Migration {

	public function up()
	{
		Schema::create('conversations', function(Blueprint $table) {
			$table->bigInteger('conversation_id')->primary()->unsigned();
			$table->bigInteger('message_id')->unsigned()->index();
		});
	}

	public function down()
	{
		Schema::drop('conversations');
	}
}
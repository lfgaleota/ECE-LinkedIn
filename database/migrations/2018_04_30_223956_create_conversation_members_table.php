<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConversationMembersTable extends Migration {

	public function up()
	{
		Schema::create('conversation_members', function(Blueprint $table) {
			$table->bigInteger('conversation_id')->unsigned();
			$table->integer('user_id')->unsigned();

            $table->primary(['conversation_id', 'user_id']);
		});
	}

	public function down()
	{
		Schema::drop('conversation_members');
	}
}
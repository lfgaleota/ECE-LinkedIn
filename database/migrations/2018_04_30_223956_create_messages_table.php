<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration {

	public function up()
	{
		Schema::create('messages', function(Blueprint $table) {
			$table->bigInteger('message_id')->primary()->unsigned();
			$table->integer('author_id')->unsigned()->index();
			$table->enum('type', array('TEXT', 'IMAGE', 'VIDEO'));
			$table->text('content');
			$table->timestamp('updated_at')->useCurrent();
            			$table->timestamp('created_at')->useCurrent();;
		});
	}

	public function down()
	{
		Schema::drop('messages');
	}
}
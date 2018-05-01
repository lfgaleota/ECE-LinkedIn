<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration {

	public function up()
	{
		Schema::create('events', function(Blueprint $table) {
			$table->bigInteger('event_id')->primary()->unsigned();
			$table->integer('author_id')->unsigned()->index();
			$table->datetime('date');
			$table->string('name');
			$table->string('description')->nullable();
			$table->string('location');
			$table->timestamp('updated_at')->useCurrent();
            			$table->timestamp('created_at')->useCurrent();;
		});
	}

	public function down()
	{
		Schema::drop('events');
	}
}
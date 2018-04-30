<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEntitiesTable extends Migration {

	public function up()
	{
		Schema::create('entities', function(Blueprint $table) {
			$table->increments('entity_id');
			$table->integer('author_id')->unsigned()->index();
			$table->string('name');
			$table->string('location')->nullable();
			$table->string('photo_url')->nullable();
			$table->string('description')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('entities');
	}
}
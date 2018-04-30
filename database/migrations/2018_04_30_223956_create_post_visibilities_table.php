<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostVisibilitiesTable extends Migration {

	public function up()
	{
		Schema::create('post_visibilities', function(Blueprint $table) {
			$table->bigInteger('post_id')->unsigned();
			$table->integer('user_id')->unsigned();

            $table->primary(['post_id', 'user_id']);
		});
	}

	public function down()
	{
		Schema::drop('post_visibilities');
	}
}
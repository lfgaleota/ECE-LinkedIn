<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubPostsTable extends Migration {

	public function up()
	{
		Schema::create('sub_posts', function(Blueprint $table) {
			$table->bigInteger('parent_post_id')->unsigned();
			$table->bigInteger('child_post_id')->unsigned();

            $table->primary(['parent_post_id', 'child_post_id']);
		});
	}

	public function down()
	{
		Schema::drop('sub_posts');
	}
}
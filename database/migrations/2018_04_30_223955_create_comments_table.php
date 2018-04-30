<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

	public function up()
	{
		Schema::create('comments', function(Blueprint $table) {
			$table->bigInteger('comment_id')->primary()->unsigned();
			$table->bigInteger('post_id')->unsigned()->index();
			$table->integer('author_id')->unsigned()->index();
			$table->text('text');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('comments');
	}
}
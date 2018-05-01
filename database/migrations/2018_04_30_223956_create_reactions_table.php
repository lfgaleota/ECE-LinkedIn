<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReactionsTable extends Migration {

	public function up()
	{
		Schema::create('reactions', function(Blueprint $table) {
			$table->bigInteger('reaction_id')->primary()->unsigned();
			$table->bigInteger('post_id')->unsigned()->nullable()->index();
			$table->bigInteger('comment_id')->unsigned()->nullable()->index();
			$table->integer('author_id')->unsigned()->index();
			$table->enum('type', array('LIKE', 'LOVE', 'LOL', 'WOW', 'SAD', 'ANGRY'));
			$table->timestamp('updated_at')->useCurrent();
            			$table->timestamp('created_at')->useCurrent();;
		});
	}

	public function down()
	{
		Schema::drop('reactions');
	}
}
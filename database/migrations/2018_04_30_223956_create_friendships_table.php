<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFriendshipsTable extends Migration {

	public function up()
	{
		Schema::create('friendships', function(Blueprint $table) {
			$table->integer('friend1_id')->unsigned();
			$table->integer('friend2_id')->unsigned();
			$table->timestamp('updated_at')->useCurrent();
            			$table->timestamp('created_at')->useCurrent();;

            $table->primary(['friend1_id', 'friend2_id']);
		});
	}

	public function down()
	{
		Schema::drop('friendships');
	}
}
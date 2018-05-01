<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNetworksTable extends Migration {

	public function up()
	{
		Schema::create('networks', function(Blueprint $table) {
			$table->integer('user1_id')->unsigned();
			$table->integer('user2_id')->unsigned();
            $table->timestamp('updated_at')->useCurrent();
                        $table->timestamp('created_at')->useCurrent();;

            $table->primary(['user1_id', 'user2_id']);
		});
	}

	public function down()
	{
		Schema::drop('networks');
	}
}
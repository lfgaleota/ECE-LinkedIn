<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobOffersTable extends Migration {

	public function up()
	{
		Schema::create('job_offers', function(Blueprint $table) {
			$table->bigInteger('job_id')->primary()->unsigned();
			$table->integer('author_id')->unsigned()->index();
			$table->integer('entity_id')->unsigned()->index();
			$table->string('position');
			$table->longText('description');
			$table->timestamp('updated_at')->useCurrent();
            			$table->timestamp('created_at')->useCurrent();;
		});
	}

	public function down()
	{
		Schema::drop('job_offers');
	}
}
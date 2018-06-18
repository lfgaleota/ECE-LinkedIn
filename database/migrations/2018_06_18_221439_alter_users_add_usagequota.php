<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterUsersAddUsagequota extends Migration {

	public function up() {
		Schema::table( 'users', function( $table ) {
			$table->float( 'usagequota', 10, 4 )->default( 0 );
		} );
	}

	public function down() {
		Schema::table( 'users', function( $table ) {
			$table->dropColumn( 'usagequota' );
		} );
	}
}
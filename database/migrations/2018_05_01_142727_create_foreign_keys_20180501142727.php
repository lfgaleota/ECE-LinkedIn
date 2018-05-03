<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignKeys20180501142727 extends Migration {

    public function up()
    {
        Schema::table('networks', function(Blueprint $table) {
            $table->foreign('user1_id')->references('user_id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('networks', function(Blueprint $table) {
            $table->foreign('user2_id')->references('user_id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    public function down()
    {
        Schema::table('networks', function(Blueprint $table) {
            $table->dropForeign('networks_user1_id_foreign');
        });
        Schema::table('networks', function(Blueprint $table) {
            $table->dropForeign('networks_user2_id_foreign');
        });
    }
}
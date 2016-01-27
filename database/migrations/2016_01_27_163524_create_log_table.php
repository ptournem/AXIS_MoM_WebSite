<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
	Schema::create('logs', function (Blueprint $table) {
	    $table->increments('id');
	    $table->timestamps();
	    $table->string('message');
	    $table->integer('user_id')->unsigned()->nullable();
	    $table->foreign('user_id')
		    ->references('id')
		    ->on('users')
		    ->onDelete('cascade');
	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
	Schema::table('logs', function(Blueprint $table) {

            $table->dropForeign('logs_user_id_foreign');

        });

        Schema::drop('logs');
    }

}

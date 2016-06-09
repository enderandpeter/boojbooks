<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booklists', function (Blueprint $table) {
            $table->increments('id')->comment('The name of this booklist');
            $table->string('name');
            $table->timestamps();
            
            /*
             * A user will have many booklists
             */
            $table->integer('user_id')->unsigned()->comment('The ID of the user in the users table that owns this booklist');            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('booklists');
    }
}

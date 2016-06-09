<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('The title of this book');
            $table->string('author')->comment('The author(s) of this book');
            $table->date('publication_date')->comment('The publication date of this book');
            $table->text('description')->comment('A description of the book');
            $table->decimal('rating', 2, 1)->comment('A rating for the book between 1 and 5');
            $table->timestamps();
            
            /*
             * A booklist has many books 
             */
            $table->integer('booklist_id')->unsigned()->comment('The booklist that this book belongs to');            
            $table->foreign('booklist_id')->references('id')->on('booklists')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('books');
    }
}

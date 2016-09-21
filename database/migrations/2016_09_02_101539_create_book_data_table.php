<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department_id')->unsigned();
            $table->string('book_ISBN');
            $table->string('book_name');
            $table->string('book_author');
            $table->string('book_publish');
            $table->integer('book_price')->unsigned();
            $table->integer('book_price2')->unsigned();
            $table->string('book_status');
            $table->string('book_img');
            $table->text('book_other');
            $table->timestamps();
            $table->integer('user_id')->unsigned()->default(0);

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('book_datas');
    }
}

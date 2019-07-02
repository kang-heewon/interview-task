<?php

use Illuminate\Support\Facades\Schema;
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
      $table->bigIncrements('id');
      $table->string('name');
      $table->unsignedBigInteger('categories_id');
      $table
        ->foreign('categories_id')
        ->references('id')
        ->on('categories')
        ->onUpdate('cascade')
        ->onDelete('cascade');
      $table->string('price');
      $table->timestamps();
    });
  }
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('books');
  }
}

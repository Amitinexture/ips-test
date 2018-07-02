<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tags_id')->unsigned()->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
        });
        
        Schema::create('modules_tags_mapping', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tags_id')->unsigned();
            $table->foreign('tags_id')->references('id')->on('tags')->onDelete('cascade');

            $table->integer('module_id')->unsigned();
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');

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
        Schema::dropIfExists('modules_tags_mapping');
        Schema::dropIfExists('tags');
    }
}

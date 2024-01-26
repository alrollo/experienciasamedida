<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(false);
            $table->text('title');
            $table->text('title_slug')->nullable();
            $table->text('summary')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('dateTime');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('works_tags', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('work_id')->unsigned()->nullable();
            $table->foreign('work_id')->references('id')->on('works')->onDelete('cascade');
            $table->bigInteger('tag_id')->unsigned()->nullable();
            $table->foreign('tag_id')->references('id')->on('masters_options')->onDelete('cascade');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('works_tags');
        Schema::dropIfExists('works');
        Schema::enableForeignKeyConstraints();
    }
}

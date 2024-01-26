<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('file_extension')->nullable();
            $table->string('file_type')->nullable();
            $table->string('file_size')->nullable();
            $table->integer('order')->default(0);
            $table->enum('type', ['image', 'doc']);
            $table->string('tag')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->morphs('attachable');
            $table->boolean('enc')->default(false);
            $table->text('hash')->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('files');
        Schema::enableForeignKeyConstraints();
    }
}

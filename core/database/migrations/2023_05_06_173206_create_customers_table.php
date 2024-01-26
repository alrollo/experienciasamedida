<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_company')->default(0);
            $table->string('alias')->nullable();
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('dni')->nullable();
            $table->string('email')->nullable();
            $table->string('web')->nullable();
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('town')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->date('birthdate');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('customers_phones', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('prefix');
            $table->string('phone');
            $table->string('description')->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('customers_tags', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->bigInteger('option_id')->unsigned()->nullable();
            $table->foreign('option_id')->references('id')->on('masters_options')->onDelete('cascade');
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
        Schema::dropIfExists('customers_tags');
        Schema::dropIfExists('customers_phones');
        Schema::dropIfExists('customers');
        Schema::enableForeignKeyConstraints();
    }
}

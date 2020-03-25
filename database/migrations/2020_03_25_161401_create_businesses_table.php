<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('store_name');
            $table->string('address');
            $table->string('parish');
            $table->string('county');
            $table->string('district');
            $table->string('postal_code');
            $table->double('lat',8,5);
            $table->double('long',8,5);
            $table->string('phone_number');
            $table->string('sector');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('contact');
            $table->string('email');
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
        Schema::dropIfExists('businesses');
    }
}

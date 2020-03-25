<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmissionEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submission_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('submission_id');
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
            $table->timestamps();
            $table->foreign('business_id')->references('id')->on('businesses');
            $table->foreign('submission_id')->references('id')->on('submissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submission_entries');
    }
}

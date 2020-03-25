<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmissionEntrySchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submission_entry_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('submission_entry_id');
            $table->time('start_hour');
            $table->time('end_hour');
            $table->boolean('sunday');
            $table->boolean('monday');
            $table->boolean('tuesday');
            $table->boolean('wednesday');
            $table->boolean('thrusday');
            $table->boolean('friday');
            $table->boolean('saturday');
            $table->unsignedTinyInteger('type');
            $table->timestamps();
            $table->foreign('submission_entry_id')->references('id')->on('submission_entries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submission_entry_schedules');
    }
}

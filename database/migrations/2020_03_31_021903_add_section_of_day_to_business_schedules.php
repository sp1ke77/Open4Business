<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSectionOfDayToBusinessSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_schedules', function (Blueprint $table) {
            $table->unsignedTinyInteger('section_of_day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_schedules', function (Blueprint $table) {
            $table->dropColumn('section_of_day');
        });
    }
}

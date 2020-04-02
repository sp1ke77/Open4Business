<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAppointmentCollumnsToBusinessSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_schedules', function (Blueprint $table) {
            $table->boolean("by_appointment")->default(false);
            $table->string('by_appointment_contacts')->nullable();
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
            $table->dropColumn("by_appointment");
            $table->dropColumn("by_appointment_contacts");
        });
    }
}

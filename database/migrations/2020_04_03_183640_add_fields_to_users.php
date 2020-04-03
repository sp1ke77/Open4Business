<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('position')->nullable();
            $table->string('company')->nullable();
            $table->string('contact')->nullable();
            $table->boolean('authorized')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name');
            $table->dropColumn('firstname');
            $table->dropColumn('lastname');
            $table->dropColumn('position');
            $table->dropColumn('company');
            $table->dropColumn('contact');
            $table->dropColumn('authorized');
        });
    }
}

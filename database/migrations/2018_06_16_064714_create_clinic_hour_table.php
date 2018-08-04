<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicHourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_hour', function (Blueprint $table) {
            $table->unsignedTinyInteger('week_day');
            $table->char('am_pm',2);
            $table->unsignedTinyInteger('room');
            $table->string('department');
            $table->string('doctor');
        
            $table->primary(['week_day','am_pm','room']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_hour');
    }
}

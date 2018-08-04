<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_info', function (Blueprint $table) {
            $table->date('date');
            $table->char('am_pm',2);
            $table->unsignedTinyInteger('room');
            $table->string('doctor');
            $table->char('patient_id',10);
            $table->integer('register_no');
            $table->timestamps();

            $table->primary(['date','am_pm','room','patient_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_info');
    }
}

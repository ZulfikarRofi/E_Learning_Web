<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId("siswa_id")->constrained('siswa')->onDelete("cascade");
            $table->foreignId("task_id")->constrained("task")->onDelete("cascade");
            $table->dateTime("date_submited");
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
        Schema::dropIfExists('task_siswa');
    }
}

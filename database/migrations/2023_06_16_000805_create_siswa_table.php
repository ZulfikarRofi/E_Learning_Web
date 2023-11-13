<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('siswa');
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->default(0)->constrained('kelas')->onDelete('cascade');
            // $table->foreignId('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('photo')->nullable();
            $table->integer('nis');
            $table->date('ttl');
            $table->string('tahun_masuk');
            $table->string('jenis_kelamin');
            $table->string('status_siswa');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswa');
    }
}

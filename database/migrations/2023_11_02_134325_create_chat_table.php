<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('chat');
        Schema::create('chat', function (Blueprint $table) {
            $table->id();
            $table->signedBigInteger('list_id');
            $table->foreign('list_id')->references('id')->on('list_chat');
            $table->LongText('message_fill');
            $table->string('message_number');
            $table->string('message_type');
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
        Schema::dropIfExists('chat');
    }
}

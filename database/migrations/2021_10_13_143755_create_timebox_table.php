<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeboxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timebox', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->json('start_time');
            $table->json('end_time');
            $table->json('recurrence_rule');
            $table->string('recurrence_type');
            $table->dateTime('recurrence_start');
            $table->dateTime('recurrence_end');
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
        Schema::dropIfExists('timebox');
    }
}

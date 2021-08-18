<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracksReadModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks_read_model', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->text('name');
            $table->longText('description')->nullable();
            $table->integer('slots')->nullable();
            $table->boolean('enabled')->default(true);
            $table->string('price')->default('$0.00');
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
        Schema::dropIfExists('tracks_read_model');
    }
}

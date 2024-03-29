<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->text('name');
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('karts');
    }
}

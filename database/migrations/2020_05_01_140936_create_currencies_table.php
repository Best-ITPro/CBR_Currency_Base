<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->bigInteger('id')->unique();  // уникальный
            $table->string('CurrID')->unique();  // уникальный
            $table->string('NumCode');
            $table->string('CharCode');
            $table->integer('Nominal');
            $table->string('Name');
            $table->timestamps();
            $table->index('CurrID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}

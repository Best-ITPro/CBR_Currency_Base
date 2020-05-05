<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_dates', function (Blueprint $table) {
            $table->bigInteger('id')->unique();  // уникальный
            $table->string('CurrID');
            $table->double('Value');
            $table->integer('Nominal');
            $table->string('DateValue');
            $table->foreign('CurrID')->references('CurrID')->on('currencies');
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
        Schema::dropIfExists('currency_dates');
    }
}

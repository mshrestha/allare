<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddFoodSupplimentCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add__food__suppliment-_countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('period');
            $table->string('period_name');
            $table->string('value');
            $table->string('organization');
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
        Schema::dropIfExists('add__food__suppliment-_countries');
    }
}

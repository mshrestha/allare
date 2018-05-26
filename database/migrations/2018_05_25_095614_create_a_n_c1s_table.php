<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateANC1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_n_c1s', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value')->nullable();
            $table->string('period');
            $table->string('period_name');
            $table->string('organisation_unit')->nullable();
            $table->string('category_option_combo')->nullable();
            $table->date('import_date');
            $table->string('server')->nullable();
            $table->string('source')->nullable();
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
        Schema::dropIfExists('a_n_c1s');
    }
}

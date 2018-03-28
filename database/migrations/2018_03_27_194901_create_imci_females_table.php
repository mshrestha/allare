<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImciFemalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imci_female', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value')->nullable();
            $table->string('period');
            $table->string('organisation_unit')->nullable();
            $table->string('category_option_combo')->nullable();
            $table->date('import_date');
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
        Schema::dropIfExists('imci_female');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateANCCounselDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_n_c__counsel-_divisions', function (Blueprint $table) {
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
        Schema::dropIfExists('a_n_c__counsel-_divisions');
    }
}

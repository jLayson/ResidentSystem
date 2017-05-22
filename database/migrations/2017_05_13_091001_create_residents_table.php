<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name_first')->nullable();
            $table->string('name_last')->nullable();
            $table->string('name_middle')->nullable();
            $table->string('address')->nullable();
            $table->string('number_home')->nullable();
            $table->string('number_mobile')->nullable();
            $table->date('birth_date')->nullable();
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
        Schema::dropIfExists('residents');
    }
}

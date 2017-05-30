<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\ReportNature;

class ReportNatureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_natures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nature_name');
            $table->timestamps();
        });

        ReportNature::create([
            'nature_name' => 'Tresspassing',
        ]);

        ReportNature::create([
            'nature_name' => 'Disturbance of Peace',
        ]);

        ReportNature::create([
            'nature_name' => 'Suspicious Person',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_natures');
    }
}

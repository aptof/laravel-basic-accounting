<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('years', function (Blueprint $table) {
            $table->id();
            $table->integer('year')->unique();
            $table->boolean('is_open')->default(true);
            $table->date('date');
            $table->boolean('tax_ok')->default(false);
            $table->boolean('depreciation_ok')->default(false);
            $table->boolean('pl_ok')->default(false);
            $table->boolean('pla_ok')->default(false);
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
        Schema::dropIfExists('years');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepreciationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depreciations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ledger_id');
            $table->double('rate', 5, 2)->default(0);
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('buy_first', 15, 2)->default(0);
            $table->decimal('buy_last', 15, 2)->default(0);
            $table->decimal('sell_first', 15, 2)->default(0);
            $table->decimal('sell_last', 15, 2)->default(0);
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
        Schema::dropIfExists('depreciations');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgerDefinitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledger_definitions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->enum('type', ['Depreciable Asset', 'Other Asset', 'Liabilities', 'Income', 'Expense', 'Capital', 'Drawing', 'Tax']);
            $table->integer('rate')->nullable();
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
        Schema::dropIfExists('ledger_definitions');
    }
}

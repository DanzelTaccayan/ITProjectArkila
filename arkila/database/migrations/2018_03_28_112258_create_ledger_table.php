<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLedgerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledger', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('ledger_id');

            $table->string('description');
            $table->string('payee')
            ->nullable();
            $table->string('or_number')
            ->nullable();
            $table->decimal('amount', 11, 2);

            $table->enum('type', ['Revenue', 'Expense']);

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
        Schema::dropIfExists('ledger');
    }
}

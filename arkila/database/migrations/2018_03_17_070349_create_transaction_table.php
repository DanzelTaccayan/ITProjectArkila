<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('transaction_id');
            $table->integer('ticket_id')
            ->unsigned()
            ->nullable();

            $table->integer('trip_id')
            ->nullable()
            ->unsigned();
            $table->string('destination');
            $table->string('origin');

            $table->decimal('amount_paid', 11, 2);
            $table->enum('status', ['Pending', 'Cancelled', 'Departed','OnBoard','Refunded','Deleted']);

            $table->foreign('ticket_id')
            ->references('ticket_id')->on('ticket')
            ->onDelete('no action')
            ->onUpdate('cascade');

            $table->foreign('trip_id')
            ->references('trip_id')->on('trip')
            ->onDelete('restrict')
            ->onUpdate('cascade');

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
        Schema::dropIfExists('transaction');
    }
}

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
            $table->integer('terminal_id')
            ->unsigned();
            $table->integer('ticket_id')
            ->unsigned()
            ->nullable();
            $table->integer('destination_id')
            ->unsigned();
            $table->integer('trip_id')
                ->nullable()
            ->unsigned();

            $table->enum('status', ['Pending', 'Cancelled', 'Departed','OnBoard','Refunded','Deleted']);

            $table->foreign('terminal_id')
            ->references('terminal_id')->on('terminal')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('ticket_id')
            ->references('ticket_id')->on('ticket')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('destination_id')
            ->references('destination_id')->on('destination')
            ->onDelete('restrict')
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

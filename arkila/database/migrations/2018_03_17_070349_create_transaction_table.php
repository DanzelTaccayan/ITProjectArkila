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
            $table->string('ticket_name')
            ->nullable();

            $table->integer('trip_id')
            ->nullable()
            ->unsigned();
            $table->string('destination');
            $table->string('origin');

            $table->decimal('amount_paid', 11, 2);
            $table->enum('status', ['Pending','Accepted','Departed','Refunded','Lost/Expired','Declined']);

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

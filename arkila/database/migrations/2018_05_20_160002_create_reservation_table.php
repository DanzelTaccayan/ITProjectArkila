<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')
            ->unsigned()
            ->nullable();
            $table->integer('date_id')
            ->unsigned()
            ->nullable();

            $table->longText('rsrv_code');
            $table->longText('refund_code')
            ->nullable();
            $table->string('destination_name');
            $table->string('name');
            $table->string('contact_number');
            $table->integer('ticket_quantity');
            $table->decimal('fare', 11, 2);
            $table->dateTime('expiry_date')
            ->nullable();
            $table->enum('status', ['UNPAID', 'PAID', 'TICKET ON HAND', 'CANCELLED', 'DEPARTED', 'EXPIRED', 'REFUNDED'])
            ->default('Unpaid');
            $table->boolean('returned_slot')
            ->default(false);
            $table->boolean('is_refundable')
            ->default(false);
            $table->date('date_paid')
            ->nullable();
            $table->enum('type', ['Walk-in', 'Online']);

            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            $table->foreign('date_id')
            ->references('id')->on('reservation_date')
            ->onDelete('restrict')
            ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation');
    }
}

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

            $table->string('rsrv_code');
            $table->integer('destination_id')
            ->unsigned();
            $table->string('name');
            $table->string('contact_number');
            $table->integer('ticket_quantity');
            $table->date('expiry_date');
            $table->enum('status', ['Unpaid', 'Paid', 'Expired', 'Cancelled'])
            ->default('Unpaid');
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

            $table->foreign('destination_id')
            ->references('destination_id')->on('destination')
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

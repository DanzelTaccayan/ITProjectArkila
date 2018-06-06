<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoldTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sold_ticket', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('sold_ticket_id');

            $table->integer('ticket_id')
                ->unsigned();

            $table->integer('boarded_at')
                ->unsigned()
                ->nullable();

            $table->integer('reservation_id')
                ->unsigned()
                ->nullable();

            $table->decimal('amount_paid', 11, 2);
            $table->enum('status', ['Pending','OnBoard']);
            $table->boolean('is_expired')
            ->default(false);
            $table->timestamps();

            $table->foreign('ticket_id')
                ->references('ticket_id')->on('ticket')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('boarded_at')
                ->references('destination_id')->on('destination')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('reservation_id')
                ->references('id')->on('reservation')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sold_ticket');
    }
}

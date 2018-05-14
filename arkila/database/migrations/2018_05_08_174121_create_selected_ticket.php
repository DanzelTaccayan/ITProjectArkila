<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelectedTicket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selected_ticket', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('selected_ticket_id');

            $table->integer('ticket_id')
                ->unsigned();


            $table->foreign('ticket_id')
                ->references('ticket_id')->on('ticket')
                ->onDelete('cascade')
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
        //
    }
}

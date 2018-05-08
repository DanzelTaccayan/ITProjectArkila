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

            $table->integer('destination_id')
                ->unsigned();

            $table->enum('type',['Regular','Discount']);


            $table->foreign('destination_id')
                ->references('destination_id')->on('destination')
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

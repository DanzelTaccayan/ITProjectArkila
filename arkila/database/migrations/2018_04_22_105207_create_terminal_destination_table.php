<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminalDestinationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminal_destination', function (Blueprint $table) {
            $table->integer('destination_id')
            ->unsigned();
            $table->integer('terminal_id')
            ->unsigned();
            $table->integer('terminal_origin')
            ->unsigned();

            $table->foreign('destination_id')
            ->references('destination_id')->on('destination')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('terminal_id')
            ->references('terminal_id')->on('terminal')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('terminal_origin')
            ->references('terminal_origin')->on('terminal')
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
        Schema::dropIfExists('terminal_destination');
    }
}

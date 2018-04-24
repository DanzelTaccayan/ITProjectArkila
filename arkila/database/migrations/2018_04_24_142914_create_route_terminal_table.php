<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouteTerminalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_terminal', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('terminal_origin')
            ->unsigned();
            $table->integer('route')
            ->unsigned();
            $table->integer('terminal_destination')
            ->unsigned();

            $table->foreign('terminal_origin')
            ->references('destination_id')->on('destination')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('route')
            ->references('destination_id')->on('destination')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('terminal_destination')
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
        Schema::dropIfExists('route_terminal');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminalRouteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminal_route', function (Blueprint $table) {
            $table->integer('terminal_id')
            ->unsigned();
            $table->integer('route_id')
            ->unsigned();

            $table->foreign('terminal_id')
            ->references('id')->on('destination')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('route_id')
            ->references('id')->on('destination')
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
        Schema::dropIfExists('terminal_route');
    }
}

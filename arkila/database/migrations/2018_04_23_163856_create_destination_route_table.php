<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinationRouteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destination_route', function (Blueprint $table) {
            $table->integer('destination_id')
            ->unsigned();
            $table->integer('route_id')
            ->unsigned();

            $table->foreign('destination_id')
            ->references('id')->on('destination')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            $table->foreign('route_id')
            ->references('route_id')->on('route')
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
        Schema::dropIfExists('destination_route');
    }
}

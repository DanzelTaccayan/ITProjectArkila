<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destination', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('origin')
            ->unsigned();
            $table->integer('destination')
            ->unsigned();

            $table->foreign('origin')
            ->references('terminal_id')->on('terminal')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            $table->foreign('destination')
            ->references('terminal_id')->on('terminal')
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
        Schema::dropIfExists('destination');
    }
}

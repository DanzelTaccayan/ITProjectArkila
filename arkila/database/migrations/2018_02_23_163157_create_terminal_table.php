<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminal', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('terminal_id');

            $table->string('name');
            $table->decimal('booking_fee', 11, 2);
            $table->decimal('fare_amount', 11, 2);
            $table->decimal('st_fare_amount', 11, 2);
            $table->boolean('is_main_terminal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('terminal');
    }
}

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
            $table->increments('destination_id');
            $table->string('destination_name');
            $table->decimal('booking_fee', 11, 2)
            ->nullable();
            $table->decimal('short_trip_fare', 11, 2)
            ->nullable();
            $table->boolean('is_terminal');
            $table->boolean('is_main_terminal');
            $table->timestamps();
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

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
            $table->increments('terminal_id', 10);
            $table->string('description', 50);
            $table->double('booking_fee', 3)->unsigned();
            $table->boolean('isMain')
            ->default(false);
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
        Schema::dropIfExists('terminal');
    }
}

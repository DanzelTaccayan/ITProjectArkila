<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('ticket_id');
            $table->string('ticket_number');
            $table->integer('destination_id')
            ->unsigned();
            $table->boolean('isAvailable');
            $table->decimal('fare', 11, 2);
            $table->enum('type',['Discount','Regular']);
            $table->timestamps();

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
        Schema::dropIfExists('ticket');
    }
}

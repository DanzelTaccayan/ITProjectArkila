<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')
            ->unsigned()
            ->nullable();

            $table->integer('destination_id')
            ->unsigned();
            $table->string('name', 70);
            $table->string('departure_date', 10);
            $table->string('departure_time', 8);
            $table->smallInteger('number_of_seats');
            $table->string('contact_number', 13);
            $table->decimal('amount', 7, 2);
            $table->enum('status', ['Accepted', 'Pending', 'Declined', 'Paid']);
            $table->enum('type', ['Walk-in', 'Online']);
            $table->string('comments', 300)
            ->nullable();

            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            $table->foreign('destination_id')
            ->references('destination_id')->on('destination')
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
        Schema::dropIfExists('reservation');
    }
}

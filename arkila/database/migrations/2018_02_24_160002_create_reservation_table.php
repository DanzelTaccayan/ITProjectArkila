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

            $table->string('destination_name');
            $table->string('name');
            $table->string('departure_date');
            $table->string('departure_time');
            $table->smallInteger('number_of_seats');
            $table->string('contact_number');
            $table->decimal('amount', 11, 2);
            $table->enum('status', ['Accepted', 'Pending', 'Declined', 'Paid']);
            $table->enum('type', ['Walk-in', 'Online']);
            $table->string('comments')
            ->nullable();

            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')->on('users')
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

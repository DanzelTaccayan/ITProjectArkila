<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanRentalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('van_rental', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('rent_id');
            $table->integer('van_id')
            ->unsigned()
            ->nullable();
            $table->integer('user_id')
            ->unsigned()
            ->nullable();

            $table->string('customer_name');

            $table->date('departure_date');
            $table->time('departure_time');
            $table->string('destination');
            $table->string('contact_number');
            $table->enum('status', ['Departed', 'Pending', 'Declined', 'Accepted','Cancelled','Expired', 'Paid', 'Refunded'])
            ->default('Pending');
            $table->enum('cancelled_by', ['Customer', 'Driver'])
            ->nullable();
            $table->enum('rent_type', ['Online', 'Walk-in']);
            $table->text('comments')
            ->nullable();
            $table->timestamps();    
            
            $table->foreign('van_id')
            ->references('van_id')->on('van')
            ->onDelete('restrict')
            ->onUpdate('cascade');

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
        Schema::dropIfExists('van_rental');
    }
}

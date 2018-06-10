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
            $table->integer('driver_id')
            ->unsigned()
            ->nullable();

            $table->longText('rental_code');
            $table->longText('refund_code')
            ->nullable();
            $table->boolean('is_refundable')
            ->default(false);
            $table->decimal('rental_fare', 11, 2)
            ->nullable();
            $table->decimal('cancellation_fee', 11,2);
            $table->decimal('rental_fee', 11,2)
            ->nullable();

            $table->longText('customer_name');

            $table->date('departure_date');
            $table->time('departure_time');
            $table->integer('number_of_days')
            ->unsigned();
            $table->string('destination');
            $table->longText('contact_number');
            $table->date('date_paid')
            ->nullable();
            $table->enum('status', ['Departed', 'Pending', 'No Van Available', 'Unpaid','Cancelled','Expired', 'Paid', 'Refunded'])
            ->default('Pending');
            $table->enum('rent_type', ['Online', 'Walk-in']);
            $table->text('comment')
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

            $table->foreign('driver_id')
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

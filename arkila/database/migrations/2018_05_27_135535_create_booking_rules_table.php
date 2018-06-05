<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_rules', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('rule_id');
            $table->string('description');
            $table->integer('payment_due');
            $table->integer('refund_expiry');
            $table->integer('request_expiry')
            ->nullable();
            $table->decimal('cancellation_fee', 11,2);
            $table->decimal('fee', 11,2);
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
        Schema::dropIfExists('booking_rules');
    }
}

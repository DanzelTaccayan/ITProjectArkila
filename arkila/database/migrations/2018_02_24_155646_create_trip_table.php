<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('trip_id');
            $table->integer('driver_id')
            ->unsigned();

            $table->integer('van_id')
            ->unsigned()
            ->nullable();

            $table->string('destination');
            $table->string('origin');
            $table->smallInteger('total_passengers')->nullable();
            $table->decimal('total_booking_fee', 11, 2)->nullable();
            $table->decimal('community_fund', 11, 2);
            $table->decimal('SOP', 11, 2)->nullable();
            $table->date('date_departed')->nullable();
            $table->time('time_departed')->nullable();
            $table->enum('report_status', ['Pending', 'Accepted', 'Declined'])->default('Pending');

            $table->foreign('van_id')
            ->references('van_id')->on('van')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            $table->foreign('driver_id')
            ->references('member_id')->on('member')
            ->onDelete('restrict')
            ->onUpdate('cascade');

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
        Schema::dropIfExists('trip');
    }
}

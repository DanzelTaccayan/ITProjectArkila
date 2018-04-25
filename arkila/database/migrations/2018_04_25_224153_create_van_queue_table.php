<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('van_queue', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('van_queue_id');

            $table->integer('destination_id')
            ->unsigned()
            ->nullable();

            $table->integer('driver_id')
                ->unsigned()
                ->nullable();

            $table->integer('van_id')
            ->unsigned();

            $table->integer('queue_number')->nullable();
            $table->boolean('has_privilege');
            $table->enum('remarks', ['OB', 'CC', 'ER'])->nullable();

            $table->foreign('van_id')
            ->references('van_id')->on('van')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('destination_id')
            ->references('destination_id')->on('destination')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('driver_id')
                ->references('member_id')->on('member')
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
        Schema::dropIfExists('van_queue');
    }
}

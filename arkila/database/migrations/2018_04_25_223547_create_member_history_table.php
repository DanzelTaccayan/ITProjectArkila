<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_history', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('member_history_id');

            $table->integer('operator_id')
            ->unsigned()
            ->nullable();

            $table->integer('driver_id')
                ->unsigned()
                ->nullable();

            $table->timestamps();

            $table->foreign('operator_id')
            ->references('member_id')->on('member')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            $table->foreign('driver_id')
                ->references('member_id')->on('member')
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
        Schema::dropIfExists('member_history');
    }
}

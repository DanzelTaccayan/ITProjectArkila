<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('van_history', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('van_history_id');

            $table->integer('van_id')
            ->unsigned();
            $table->integer('member_id')
            ->unsigned();

            $table->timestamps();

            $table->foreign('van_id')
            ->references('van_id')->on('van')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            $table->foreign('member_id')
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
        Schema::dropIfExists('van_history');
    }
}

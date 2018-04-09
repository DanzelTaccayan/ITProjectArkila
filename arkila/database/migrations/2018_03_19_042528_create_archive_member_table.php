<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchiveMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archive_member', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('archive_member_id');

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
        Schema::dropIfExists('archive_member');
    }
}

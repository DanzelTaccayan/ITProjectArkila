<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchiveMemberVanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archive_member_van', function (Blueprint $table) {
            $table->integer('member_id')
            ->unsigned();
            $table->string('plate_number', 9);

            $table->foreign('plate_number')
            ->references('plate_number')->on('van')
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
        Schema::dropIfExists('archive_member_van');
    }
}

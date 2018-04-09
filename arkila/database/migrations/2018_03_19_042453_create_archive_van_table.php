<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchiveVanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archive_van', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('archive_van_id');

            $table->string('plate_number', 9);
            $table->integer('member_id')
                ->unsigned();

            $table->timestamps();

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
        Schema::dropIfExists('archive_van');
    }
}

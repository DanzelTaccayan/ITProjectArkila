<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('van', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('van_id');
            $table->string('plate_number')
            ->unique();
            
            $table->integer('model_id')
            ->unsigned();
            $table->smallInteger('seating_capacity');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->string('location');


            $table->timestamps();

            $table->foreign('model_id')
            ->references('model_id')->on('van_model')
            ->onDelete('restrict')
            ->onUpdate('restrict');


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('van');
    }
}

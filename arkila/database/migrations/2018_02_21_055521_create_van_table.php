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
            $table->string('plate_number', 8)
            ->unique();

            $table->integer('model_id')
            ->unsigned();       
            $table->string('seating_capacity', 2);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');


            $table->timestamps();

            $table->primary('plate_number');

            $table->foreign('model_id')
            ->references('model_id')->on('van_model')
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
        Schema::dropIfExists('van');
    }
}

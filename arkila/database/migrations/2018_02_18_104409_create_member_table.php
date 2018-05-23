<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('member_id');
            $table->integer('user_id')
            ->nullable()
            ->unsigned();

            $table->integer('operator_id')
            ->nullable()
            ->unsigned();
            $table->longText('last_name');
            $table->longText('first_name');
            $table->longText('middle_name')->nullable();
            $table->longText('contact_number');
            $table->enum('role',['Operator','Driver']);
            $table->longText('address');
            $table->longText('provincial_address');
            $table->longText('gender');
            $table->longText('person_in_case_of_emergency');
            $table->longText('emergency_address');
            $table->longText('emergency_contactno');
            $table->longText('SSS')->nullable();
            $table->longText('license_number')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->enum('notification', ['Enable', 'Disable'])->default('Enable');
            $table->date('expiry_date')->nullable();
            $table->decimal('monthly_dues', 7, 2);
            $table->string('profile_picture')->default('avatar.png');
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('restrict')
            ->onUpdate('cascade');


        });

        Schema::table('member', function (Blueprint $table) {
            $table->foreign('operator_id')
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
        Schema::dropIfExists('member');
    }
}

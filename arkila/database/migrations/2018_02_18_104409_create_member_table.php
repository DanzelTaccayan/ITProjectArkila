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
            $table->string('last_name', 35);
            $table->string('first_name', 35);
            $table->string('middle_name', 35)->nullable();
            $table->string('contact_number', 13);
            $table->enum('role', ['Operator', 'Driver']);
            $table->string('address',100);
            $table->string('provincial_address',100);
            $table->date('birth_date');
            $table->string('birth_place', 50);
            $table->smallInteger('age');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('citizenship', 35);
            $table->enum('civil_status', ['Single', 'Married', 'Divorced', 'Widowed']);
            $table->smallInteger('number_of_children')->nullable();
            $table->string('spouse', 120)->nullable();
            $table->date('spouse_birthdate')->nullable();
            $table->string('father_name', 120)->nullable();
            $table->string('father_occupation', 50)->nullable();
            $table->string('mother_name', 120)->nullable();
            $table->string('mother_occupation', 50)->nullable();
            $table->string('person_in_case_of_emergency', 120);
            $table->string('emergency_address', 50);
            $table->string('emergency_contactno', 13);
            $table->string('SSS', 20)->nullable();
            $table->string('license_number', 20)->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->enum('notification', ['Enable', 'Disable'])->default('Enable');
            $table->date('expiry_date')->nullable();
            $table->dateTime('date_archived')->nullable();
            $table->decimal('monthly_dues', 7, 2);
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

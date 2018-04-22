<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('last_name', 50);
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();

            $table->string('username', 15)->unique();
            $table->string('email')->unique()->nullable();
            $table->string('password');

            $table->enum('user_type', ['Driver', 'Customer', 'Admin', 'Super-Admin']);
            $table->enum('status', ['enable', 'disable']);

            $table->integer('terminal_id')
            ->unsigned()
            ->nullable();

            $table->rememberToken();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

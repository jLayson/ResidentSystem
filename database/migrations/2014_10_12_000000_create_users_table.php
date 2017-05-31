<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

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
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password');
            $table->integer('account_type');
            $table->boolean('is_active')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            'username' => 'admin1',
            'password' => '$2y$10$cnJmeBPsokP6Py6Tiyvtnuz5j0hfJZodJ3gSD3hN5f0Y6aeS.bXGe',
            'account_type' => 1,
            'is_active' => 1,
        ]);
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

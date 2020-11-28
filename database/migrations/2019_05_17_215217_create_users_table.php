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
            $table->bigIncrements('id');
            $table->string('name',50);
            $table->string('surname',50);
            $table->string('username',30);
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('idrol')->unsigned()->index();
            $table->foreign('idrol')->references('id')->on('roles')->onDelete('cascade');
            $table->boolean('activo')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(array('id'=>'1','name'=>'Administrador','surname'=>'Sistema','username'=>'administrador','email'=>'genaro.munoz.obregon@gmail.com','password'=>'$2y$10$0mJQ7VT0jobcA2E82LArfekveNDKzIPGJssaZQj0DBOmqHb0McyVC','idrol'=>1));

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

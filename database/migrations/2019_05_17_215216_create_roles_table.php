<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rol_descripcion',30);
            $table->boolean('rol_activo')->default('1');
            $table->timestamps();
        });

        DB::table('roles')->insert(array('id'=>'1','rol_descripcion'=>'Super Admin'));
        DB::table('roles')->insert(array('id'=>'2','rol_descripcion'=>'Administrador'));
        DB::table('roles')->insert(array('id'=>'3','rol_descripcion'=>'Customer'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}

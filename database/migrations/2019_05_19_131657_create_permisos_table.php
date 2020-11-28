<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idrol')->unsigned()->index();;
            $table->foreign('idrol')->references('id')->on('roles');
            $table->bigInteger('idmodulo')->unsigned()->index();;
            $table->foreign('idmodulo')->references('id')->on('modulos');
            $table->boolean('acceso');
            $table->boolean('consultar');
            $table->boolean('crear');
            $table->boolean('editar');
            $table->boolean('eliminar');
            $table->timestamps();
        });

        DB::table('permisos')->insert(array('id'=>'1','idrol'=>'1','idmodulo'=>1,'acceso'=>1,'consultar'=>1,'crear'=>1,'editar'=>1,'eliminar'=>1));
        DB::table('permisos')->insert(array('id'=>'2','idrol'=>'1','idmodulo'=>2,'acceso'=>1,'consultar'=>1,'crear'=>1,'editar'=>1,'eliminar'=>1));
        DB::table('permisos')->insert(array('id'=>'3','idrol'=>'1','idmodulo'=>3,'acceso'=>1,'consultar'=>1,'crear'=>1,'editar'=>1,'eliminar'=>1));
        DB::table('permisos')->insert(array('id'=>'4','idrol'=>'1','idmodulo'=>4,'acceso'=>1,'consultar'=>1,'crear'=>1,'editar'=>1,'eliminar'=>1));
        DB::table('permisos')->insert(array('id'=>'5','idrol'=>'2','idmodulo'=>1,'acceso'=>1,'consultar'=>1,'crear'=>1,'editar'=>1,'eliminar'=>1));
        DB::table('permisos')->insert(array('id'=>'6','idrol'=>'2','idmodulo'=>2,'acceso'=>1,'consultar'=>1,'crear'=>1,'editar'=>1,'eliminar'=>1));
        DB::table('permisos')->insert(array('id'=>'7','idrol'=>'2','idmodulo'=>3,'acceso'=>1,'consultar'=>1,'crear'=>1,'editar'=>1,'eliminar'=>1));
        DB::table('permisos')->insert(array('id'=>'8','idrol'=>'2','idmodulo'=>4,'acceso'=>1,'consultar'=>1,'crear'=>1,'editar'=>1,'eliminar'=>1));
        DB::table('permisos')->insert(array('id'=>'9','idrol'=>'3','idmodulo'=>1,'acceso'=>1,'consultar'=>1,'crear'=>1,'editar'=>1,'eliminar'=>1));
        DB::table('permisos')->insert(array('id'=>'10','idrol'=>'3','idmodulo'=>2,'acceso'=>1,'consultar'=>1,'crear'=>1,'editar'=>1,'eliminar'=>1));
        DB::table('permisos')->insert(array('id'=>'11','idrol'=>'3','idmodulo'=>3,'acceso'=>1,'consultar'=>1,'crear'=>1,'editar'=>1,'eliminar'=>1));
        DB::table('permisos')->insert(array('id'=>'12','idrol'=>'3','idmodulo'=>4,'acceso'=>1,'consultar'=>1,'crear'=>1,'editar'=>1,'eliminar'=>1));
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisos');
    }
}

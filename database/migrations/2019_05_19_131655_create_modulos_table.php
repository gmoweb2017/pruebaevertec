<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('modulo',50);
            $table->boolean('activo')->default(1);
            $table->timestamps();
        });

        DB::table('modulos')->insert(array('id'=>'1','modulo'=>'Configuracion','activo'=>1));
        DB::table('modulos')->insert(array('id'=>'2','modulo'=>'Productos','activo'=>1));
        DB::table('modulos')->insert(array('id'=>'3','modulo'=>'Ordenes','activo'=>1));
        DB::table('modulos')->insert(array('id'=>'4','modulo'=>'Reportes','activo'=>1));


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modulos');
    }
}

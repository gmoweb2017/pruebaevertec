<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuraciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('variable',40);
            $table->mediumtext('valor');
            $table->timestamps();
        });
        DB::table('configuraciones')->insert(array('id'=>'1','variable'=>'NombreApp','valor'=>'Demo App'));
        DB::table('configuraciones')->insert(array('id'=>'2','variable'=>'Direccion','valor'=>'Carrera 9 #57C1-07'));
        DB::table('configuraciones')->insert(array('id'=>'3','variable'=>'Copyright','valor'=>'Demage'));
        DB::table('configuraciones')->insert(array('id'=>'4','variable'=>'Email','valor'=>'genaro.munoz@demage.com.co'));
        DB::table('configuraciones')->insert(array('id'=>'5','variable'=>'Pais','valor'=>'Colombia'));
        DB::table('configuraciones')->insert(array('id'=>'6','variable'=>'Telefono','valor'=>'3217541405'));
        DB::table('configuraciones')->insert(array('id'=>'7','variable'=>'DesarrolladoPor','valor'=>'Genaro Muñoz'));
        DB::table('configuraciones')->insert(array('id'=>'8','variable'=>'WebDesarrollador','valor'=>'https://demage.com.co'));
        DB::table('configuraciones')->insert(array('id'=>'9','variable'=>'WebSitio','valor'=>'https://demage.com.co'));
        DB::table('configuraciones')->insert(array('id'=>'10','variable'=>'Logo','valor'=>'/img/logo.png'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuraciones');
    }
}

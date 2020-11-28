<?php

namespace App\Http\Controllers\Configuraciones;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;


use Image;
use App\Configuracion;

class ConfiguracionController extends Controller
{
  public function index(Request $request)
  {
      if (!$request->ajax()) return redirect('/');

      $consultando=Configuracion::get();

      //dd($consultando);
      return ['configuraciones' => $consultando];
  }


  public function cargaImagen(Request $request){
    if (!$request->ajax()) return redirect('/');
    
    if($request->file('imagen') != null){
      $image = $request->file('imagen');
      $input['imagename'] = time().'.'.$image->getClientOriginalExtension(); 
      $destinationPath = public_path('/img');     

      $img = Image::make($image->getRealPath());
      $img->resize(250, 150, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
        })->save($destinationPath.'/'.$request->name.'_'.$input['imagename']);     

      $destinationPath = public_path('/img');
      $image->move($destinationPath, $request->name.'_'.$input['imagename']);

      $valorForm = '/img/'.$request->name.'_'.$input['imagename'];
      
      
      return ['valorForm' => $valorForm, 'name'=>$request->name];

    }else{
      return ['valorForm' => '', 'name'=>$request->name];
    }   

  }

  public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //$borradoDireccion=Configura::where('valor','=','direccion')->delete();


        $direccion = DB::table('configuraciones')        
        ->where('variable', 'Direccion')
        ->update(['valor' => $request->direccion]);  
        
        $nombreApp = DB::table('configuraciones')        
        ->where('variable', 'NombreApp')
        ->update(['valor' => $request->nombreApp]);  

        $telefono = DB::table('configuraciones')        
        ->where('variable', 'Telefono')
        ->update(['valor' => $request->telefono]);  

        $Email = DB::table('configuraciones')        
        ->where('variable', 'Email')
        ->update(['valor' => $request->email]);  

        $pais = DB::table('configuraciones')        
        ->where('variable', 'pais')
        ->update(['valor' => $request->pais]);  

        $webSitio = DB::table('configuraciones')        
        ->where('variable', 'WebSitio')
        ->update(['valor' => $request->web]);  

        $logo = DB::table('configuraciones')        
        ->where('variable', 'Logo')
        ->update(['valor' => $request->imagen]);  

        $data = array(
            'message' => 'El registro se actualizó satisfactoriamente',
            'status' =>'success',
            'state' => 'success',
            'icon' => 'fa fa-bell',
            'title' => 'Registro Actualizado',
            'url'=>'#',
            'code' => 200
        );

        return response()->json($data,200);
    }

}

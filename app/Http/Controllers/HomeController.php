<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Permiso;
use App\Rol;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        //parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $id = Auth::id();
        $rol = Auth::user()->idrol;
        
        //$request->user()->authorizeRoles(['Estudiante', 'Administrador','Super Admin','Practicante']);

        return view('home');
    }

    public function usuarios(Request $request){
      $id = Auth::id();
      $rol = Auth::user()->idrol;
      $rolNo = Rol::where('id','=',$rol)->first();
      //Revisa si el rol tiene permiso      
      if(!$request->user()->authorizeRoles([$rolNo->rol_descripcion])){
        return redirect()->route('401');
      }      
      //obtiene los permisos del rol en cuanto al modulo o pagina basado en una acción
      $consultaPermiso=$request->user()->permisoArreglo($rol,1,'consultar');    
      //Si la anterior responde true sigue sino devuelve            
      if($consultaPermiso['accion']){        
        return view('Usuario.usuarios')->with('consultar',$consultaPermiso['permisos']);
      }else{
        return redirect()->route('401');
      }
    }

    public function roles(Request $request){

      $id = Auth::id();      
      $rol = Auth::user()->idrol;
      $rolNo = Rol::where('id','=',$rol)->first();
      //Revisa si el rol tiene permiso
      if(!$request->user()->authorizeRoles([$rolNo->rol_descripcion])){
        return redirect()->route('401');
      }           
      //obtiene los permisos del rol en cuanto al modulo o pagina basado en una acción
      $consultaPermiso=$request->user()->permisoArreglo($rol,1,'consultar');    
      //Si la anterior responde true sigue sino devuelve       
      if($consultaPermiso['accion']){
        
        return view('Usuario.roles')->with('consultar',$consultaPermiso['permisos']);
      }else{
        return redirect()->route('401');
      }
    }

    public function configura(Request $request){
      $id = Auth::id();
      $rol = Auth::user()->idrol;
      $rolNo = Rol::where('id','=',$rol)->first();
      //Revisa si el rol tiene permiso
      if(!$request->user()->authorizeRoles([$rolNo->rol_descripcion])){
        return redirect()->route('401');
      }         
      //obtiene los permisos del rol en cuanto al modulo o pagina basado en una acción
      $consultaPermiso=$request->user()->permisoArreglo($rol,1,'consultar');    
      //Si la anterior responde true sigue sino devuelve       
      if($consultaPermiso['accion']){
        
        return view('Configuracion.configura')->with('consultar',$consultaPermiso['permisos']);
      }else{
        return redirect()->route('401');
      }     

    }


    public function modulos(Request $request){
      $id = Auth::id();
      $rol = Auth::user()->idrol;
      $rolNo = Rol::where('id','=',$rol)->first();
      //Revisa si el rol tiene permiso
      if(!$request->user()->authorizeRoles([$rolNo->rol_descripcion])){
        return redirect()->route('401');
      }         
      //obtiene los permisos del rol en cuanto al modulo o pagina basado en una acción
      $consultaPermiso=$request->user()->permisoArreglo($rol,1,'consultar');    
      //Si la anterior responde true sigue sino devuelve       
      if($consultaPermiso['accion']){
        
        return view('Configuracion.modulo')->with('consultar',$consultaPermiso['permisos']);
      }else{
        return redirect()->route('401');
      }     

    }


}

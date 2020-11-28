<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rol;

class RolController extends Controller
{
  public function index(Request $request)
  {
      if (!$request->ajax()) return redirect('/');
      $buscar = $request->buscar;
      $criterio = $request->criterio;
      $rol = Auth::user()->idrol;
      $columna = $request->column;
      $order =$request->order;

      if($rol!=1){
        if ($buscar==''){
            $roles = Rol::where('id','!=',1)->orderBy($columna, $order)->paginate(10);
        }
        else{
            $roles = Rol::where([[$criterio, 'like', '%'. $buscar . '%'],['id','!=',1]])->orderBy($columna, $order)->paginate(10);
        }
      }else{
        if ($buscar==''){
            $roles = Rol::orderBy($columna, $order)->paginate(10);
        }
        else{
            $roles = Rol::where($criterio, 'like', '%'. $buscar . '%')->orderBy($columna, $order)->paginate(10);
        } 
      }
      return [
          'pagination' => [
              'total'        => $roles->total(),
              'current_page' => $roles->currentPage(),
              'per_page'     => $roles->perPage(),
              'last_page'    => $roles->lastPage(),
              'from'         => $roles->firstItem(),
              'to'           => $roles->lastItem(),
          ],
          'roles' => $roles
      ];
  }

  public function store(Request $request)
  {
      if (!$request->ajax()) return redirect('/');

      $consultaDuplicado=Rol::where('rol_descripcion','=',$request->descripcion)->count();
        if($consultaDuplicado>0){
            $data = array(
                'message' => 'El registro ya se encuentra en el sistema',
                'status' =>'error',
                'state' => 'danger',
                'icon' => 'fa fa-bell',
                'title' => 'Registro duplicado',
                'url'=>'#',
                'code' => 200
            );
        }else{
            $rol = new Rol();
            $rol->rol_descripcion = $request->descripcion;
            $rol->rol_activo =  $request->activo;
            $rol->save();

            $data = array(
                'message' => 'El registro se creó satisfactoriamente',
                'status' =>'success',
                'state' => 'success',
                'icon' => 'fa fa-bell',
                'title' => 'Registro Exitoso',
                'url'=>'#',
                'code' => 200
            );
        }
      return response()->json($data,200);
  }

  public function update(Request $request)
  {
      if (!$request->ajax()) return redirect('/');
      $rol = Rol::findOrFail($request->id);
      $rol->rol_descripcion = $request->descripcion;
      $rol->rol_activo = $request->activo;
      $rol->save();
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

  public function desactivar(Request $request)
  {
      if (!$request->ajax()) return redirect('/');
      $rol = Rol::findOrFail($request->id);
      $rol->rol_activo = '0';
      $rol->save();
  }

  public function activar(Request $request)
  {
      if (!$request->ajax()) return redirect('/');
      $rol = Rol::findOrFail($request->id);
      $rol->rol_activo = '1';
      $rol->save();
  }


  public function selectRol(Request $request)
  {
    $rol = Auth::user()->idrol;
    if($rol!=1){
        $roles = Rol::where([['rol_activo', '=', '1'],['id','!=',1]])
        ->select('id','rol_descripcion')
        ->orderBy('rol_descripcion', 'asc')->get();          
    }else{
        $roles = Rol::where('rol_activo', '=', '1')
        ->select('id','rol_descripcion')
        ->orderBy('rol_descripcion', 'asc')->get();
    }
      
      return ['roles' => $roles];
  }
}

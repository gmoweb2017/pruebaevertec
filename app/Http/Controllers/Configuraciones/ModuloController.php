<?php

namespace App\Http\Controllers\Configuraciones;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Modulo;

class ModuloController extends Controller
{
    public function index(Request $request)
  {
      if (!$request->ajax()) return redirect('/');

      $buscar = $request->buscar;
      $criterio = $request->criterio;
      $rol = Auth::user()->idrol;
      $columna = $request->column;
      $order =$request->order;

      if($rol==1){
        if($buscar==''){
            $listado=Modulo::orderBy($columna, $order)->paginate(10);
          }else{
            $listado=Modulo::where([[$criterio,'like','%'.$buscar.'%']])->orderBy($columna, $order)->paginate(10);
          }
      }else{        
      }
      

      return [
          'pagination' => [
              'total'        => $listado->total(),
              'current_page' => $listado->currentPage(),
              'per_page'     => $listado->perPage(),
              'last_page'    => $listado->lastPage(),
              'from'         => $listado->firstItem(),
              'to'           => $listado->lastItem(),
          ],
          'listado' => $listado
      ];
  }


  public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $consultaDuplicado=Modulo::where('modulo','=',$request->modulo)->count();
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

          $agrega= new Modulo();
          $agrega->modulo = $request->modulo;
          $agrega->activo = $request->activo;
          $agrega->save();

          $data = array(
            'message' => 'El registro se actualizó satisfactoriamente',
            'status' =>'success',
            'state' => 'success',
            'icon' => 'fa fa-bell',
            'title' => 'Registro Actualizado',
            'url'=>'#',
            'code' => 200
        );
        }
        

        return response()->json($data,200);
    }


    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $actualiza = Modulo::findOrFail($request->id);
        $actualiza->modulo = $request->modulo;
        $actualiza->activo = $request->activo;
        $actualiza->save();

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
        $desactivar = Modulo::findOrFail($request->id);
        $desactivar->activo = '0';
        $desactivar->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $activar = Modulo::findOrFail($request->id);
        $activar->activo = '1';
        $activar->save();
    }

}

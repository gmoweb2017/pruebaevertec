<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Rol;
use App\RolUser;

class UserController extends Controller
{


  public function index(Request $request)
  {
      if (!$request->ajax()) return redirect('/');

      $buscar = $request->buscar;
      $criterio = $request->criterio;
      $rol = Auth::user()->idrol;
      $columna = $request->column;
      $order =$request->order;  

      $filtro1 = $request->filtro1;  
      $filtro2 = $request->filtro2;  
      $filtro3 = $request->filtro3;  
      $filtro4 = $request->filtro4;  

      if($rol!=1){      
            $usuarios=User::where('idrol','!=',1)
            ->Nombre($filtro2)
            ->Rol($filtro1)
            ->Apellido($filtro3)
            ->Usuario($filtro4)
            ->orderBy($columna, $order)->paginate(10);
      }else{  
            $usuarios=User::orderBy($columna, $order)
            ->Nombre($filtro2)
            ->Rol($filtro1)
            ->Apellido($filtro3)
            ->Usuario($filtro4)
            ->paginate(10);   
      }


      return [
          'pagination' => [
              'total'        => $usuarios->total(),
              'current_page' => $usuarios->currentPage(),
              'per_page'     => $usuarios->perPage(),
              'last_page'    => $usuarios->lastPage(),
              'from'         => $usuarios->firstItem(),
              'to'           => $usuarios->lastItem(),
          ],
          'Usuarios' => $usuarios
      ];
  }

  public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
            $consultaDuplicado=User::where('username','=',$request->username)->orWhere('email','=',$request->email)->count();
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
              $user = new User();
              $user->idrol = $request->rol;
              $user->name = $request->name;
              $user->surname = $request->surname;
              $user->email = $request->email;
              $user->username = $request->username;
              $user->password = bcrypt( $request->password);
              $user->activo = $request->activo;
              $user->save();

              $rolUse=new RolUser();
              $rolUse->rol_id=$request->rol;
              $rolUse->user_id=$user->id;
              $rolUse->save();

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

        $user = User::findOrFail($request->id);
        $user->idrol = $request->rol;
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->username = $request->username;
        if($request->password<>''){
            $user->password = bcrypt( $request->password);
        }
        $user->activo = $request->activo;
        $user->save();

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
        $user = User::findOrFail($request->id);
        $user->activo = '0';
        $user->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->activo = '1';
        $user->save();
    }

    public function usuariologueado(Request $request)
    {
        $id = Auth::id();
        $rol = Auth::user()->idrol;
        $name = Auth::user()->name.' '.Auth::user()->surname;

        return ['nombre' => $name,'id'=>$id];
    }
}

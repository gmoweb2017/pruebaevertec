<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Product;

class ProductController extends Controller
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


        $listado=Product::orderBy($columna, $order)->paginate(10);   


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

    public function indexFront(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $columna = $request->column;
        $order =$request->order;  

        $filtro1 = $request->filtro1;  
        $filtro2 = $request->filtro2;  
        $filtro3 = $request->filtro3;  
        $filtro4 = $request->filtro4;  


        $listado=Product::orderBy($columna, $order)->paginate(10);   


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
            $consultaDuplicado=Product::where('nombreProducto','=',$request->nombreProducto)
            ->count();

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

                $agregar = Product::create([
                    'nombreProducto' => $request->nombreProducto,
                    'precio' => $request->precio,
                    'activo' => $request->activo
                ]);

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

        $actualiza = Product::findOrFail($request->id);
        $actualiza->nombreProducto = $request->nombreProducto;
        $actualiza->precio = $request->precio;
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
        $item = Product::findOrFail($request->id);
        $item->activo = '0';
        $item->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $item = Product::findOrFail($request->id);
        $item->activo = '1';
        $item->save();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Order;

class OrderController extends Controller
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


        $listado=Order::with('order_details')->with('order_details.product')->with('customer')->orderBy($columna, $order)->paginate(10);   


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
}

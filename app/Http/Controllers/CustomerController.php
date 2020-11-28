<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Customer;


class CustomerController extends Controller
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


        $listado=Customer::orderBy($columna, $order)->paginate(10);   


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
            $consultaDuplicado=Customer::where('customer_email','=',$request->customer_email)
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

                $agregar = Customer::create([
                    'customer_name' => $request->customer_name,
                    'customer_address' => $request->customer_address,
                    'customer_mobile' => $request->customer_mobile,
                    'customer_email' => $request->customer_email
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

        $actualiza = Customer::findOrFail($request->id);
        $actualiza->customer_name = $request->customer_name;
        $actualiza->customer_address = $request->customer_address;
        $actualiza->customer_email = $request->customer_email;
        $actualiza->customer_mobile = $request->customer_mobile;
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

   

}

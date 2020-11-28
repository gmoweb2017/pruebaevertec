<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use App\Configuracion;

class LoginController extends Controller
{
    public function showLoginForm(){


        if(Auth::check()){
            return redirect()->route('tablero');
        }else{
            return view('auth.login');
        }

    }

    public function login(Request $request){
        //Hace referencia a la funcion de validar login

        if (Auth::attempt(['username' => $request->usuario,'password' => $request->password,'activo'=>1])){
            return redirect()->route('tablero');
        }else if(Auth::attempt(['username' => $request->usuario,'password' => $request->password,'activo'=>0])){
            //Regresa un mensaje y con el withinput devuelve en el input el valor diligenciado
            return back()
            ->withErrors(['usuario' => trans('auth.inactive')])
            ->withInput(request(['usuario']));
        }else{
            //Regresa un mensaje y con el withinput devuelve en el input el valor diligenciado
            return back()
            ->withErrors(['usuario' => trans('auth.failed')])
            ->withInput(request(['usuario']));
        }
    }

    protected function validateLogin(Request $request){
        $this->validate($request,[
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

    }

    public function logout(Request $request){
        //$request->user()->authorizeRoles(['Administrador','Super Admin']);
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}

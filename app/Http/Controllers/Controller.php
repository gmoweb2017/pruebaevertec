<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Configuracion;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $nameApp;
    private $address;
    private $copy;
    private $phone;
    private $phone2;
    private $country;
    private $email;
    private $developer;
    private $Webdeveloper;
    private $Web;
    private $Logo;

    public function __construct()
    {
       
        $this->middleware(function ($request, $next) {
            $this->nameApp = Configuracion::select('valor')->where('variable','=','NombreApp')->first();
            $this->address = Configuracion::select('valor')->where('variable','=','Direccion')->first();
            $this->copy = Configuracion::select('valor')->where('variable','=','Copyright')->first();
            $this->email = Configuracion::select('valor')->where('variable','=','Email')->first();
            $this->country = Configuracion::select('valor')->where('variable','=','Pais')->first();  
            $this->phone = Configuracion::select('valor')->where('variable','=','Telefono')->first();
            $this->developer = Configuracion::select('valor')->where('variable','=','DesarrolladoPor')->first();
            $this->Webdeveloper = Configuracion::select('valor')->where('variable','=','WebDesarrollador')->first();
            $this->Web = Configuracion::select('valor')->where('variable','=','WebSitio')->first();
            $this->Logo = Configuracion::select('valor')->where('variable','=','Logo')->first();


            view()->share('address', $this->address->valor);
            view()->share('nameApp', $this->nameApp->valor);
            view()->share('copy', $this->copy->valor);
            view()->share('phone', $this->phone->valor);
            view()->share('country', $this->country->valor);
            view()->share('email', $this->email->valor);
            view()->share('developer', $this->developer->valor);
            view()->share('webdeveloper', $this->Webdeveloper->valor);
            view()->share('web', $this->Web->valor);
            view()->share('logo', $this->Logo->valor);

            return $next($request);
        });



    }
}

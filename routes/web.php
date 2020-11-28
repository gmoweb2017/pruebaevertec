<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/401', function () {
  return view('error.401', ['error' => 'No tienes permisos']);
})->name('401');


Route::group(['middleware' => ['web']], function () {
  Route::get('/login','Auth\LoginController@showLoginForm');
  Route::post('/login', 'Auth\LoginController@login')->name('login');

  Route::get('/',function () {
    return view('front.index');
  });


  Route::prefix('ProductFront')->group(function(){        
    Route::get('/listado', 'ProductController@indexFront');
  });

});



Route::group(['middleware' => ['auth']], function () {

  Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

  //Route::get('/usuarios/usuariologueado', 'UserController@usuariologueado');

  Route::get('/tablero', 'HomeController@index')->name('tablero');



  //Route::group(['middleware' => ['Administrador']], function () {

      Route::prefix('Usuario')->group(function(){        
        Route::get('/', 'HomeController@usuarios')->name('Usuario.usuarios');
        Route::get('/listado', 'UserController@index');
        Route::post('/registrar', 'UserController@store');
        Route::put('/actualizar', 'UserController@update');
        Route::put('/desactivar', 'UserController@desactivar');
        Route::put('/activar', 'UserController@activar');
      });

      Route::prefix('Customer')->group(function(){        
        Route::get('/', 'HomeController@customers')->name('Customer.index');
        Route::get('/listado', 'CustomerController@index');
        Route::post('/registrar', 'CustomerController@store');
        Route::put('/actualizar', 'CustomerController@update');
      });

      Route::prefix('Product')->group(function(){        
        Route::get('/', 'HomeController@products')->name('Product.index');
        Route::get('/listado', 'ProductController@index');
        Route::post('/registrar', 'ProductController@store');
        Route::put('/actualizar', 'ProductController@update');
        Route::put('/desactivar', 'ProductController@desactivar');
        Route::put('/activar', 'ProductController@activar');
      });


      Route::prefix('Order')->group(function(){        
        Route::get('/', 'HomeController@orders')->name('Order.index');
        Route::get('/listado', 'OrderController@index');
      });

      
      Route::prefix('Modulo')->group(function(){        
        Route::get('/', 'HomeController@modulos')->name('Configuracion.modulo');
        Route::get('/listado', 'Configuraciones\ModuloController@index');
        Route::post('/registrar', 'Configuraciones\ModuloController@store');
        Route::put('/actualizar', 'Configuraciones\ModuloController@update');
        Route::put('/desactivar', 'Configuraciones\ModuloController@desactivar');
        Route::put('/activar', 'Configuraciones\ModuloController@activar');
      });

      Route::prefix('Roles')->group(function(){        
        Route::get('/', 'HomeController@roles')->name('Usuario.roles');
        Route::post('/registrar', 'RolController@store');
        Route::put('/actualizar', 'RolController@update');
        Route::get('/selectRol', 'RolController@selectRol');
        Route::get('/listado', 'RolController@index');
        Route::put('/desactivar', 'RolController@desactivar');
        Route::put('/activar', 'RolController@activar');
      });

      Route::prefix('Configuracion')->group(function(){        
        Route::get('/', 'HomeController@configura')->name('Configuracion.configura');       
        Route::get('/listado', 'Configuraciones\ConfiguracionController@index');
        Route::post('/registrar', 'Configuraciones\ConfiguracionController@store');
        Route::put('/cargaImagen', 'Configuraciones\ConfiguracionController@cargaImagen');
      });      

      

      //Route::get('/Pedido/listado', 'PedidoController@index');




  //});

  


});


/*Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
*/

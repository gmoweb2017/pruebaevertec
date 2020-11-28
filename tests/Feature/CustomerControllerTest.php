<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testnavegacionPantallaCustomers()
    {
        $response = $this->get(route('customers.index'));

        $response->assertStatus(200);
        //$response->assertViewIs('auth.login');
    }

    public function testobtenerListadoCustomers(){
        $response = $this->get('/Customer/listado');

        
        $response->assertStatus(200);
        //$response->assertViewIs('auth.login');
    }

    public function testinsertaRegistroCustomer(){

        $user = \App\User::where(['username' => 'admin','password'=>'prueba'])->get();
        auth()->login($user);

       
        $response = $this->post(route('/Customer/registrar'), [
            'customer_name' => 'Genaro Muñoz',
            'customer_address' => 'Carrera 9 # 57C1-08',
            'customer_email' => 'genaro.munoz.obregon@gmail.com',
            'customer_mobile' => '3217541405',
        ]);
    
        $response->assertRedirect(route('customer.index'));

        $this->assertDatabaseHas('customers', [
            'customer_name' => 'Genaro Muñoz',
            'customer_name' => 'genaro.munoz.obregon@gmail.com'
        ]);
    }
}

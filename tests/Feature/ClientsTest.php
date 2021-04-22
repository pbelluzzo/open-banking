<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Clients;

class ClientsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_client_can_be_added()
    {
        $this->post('/api/clients', $this->getFakeData());

        $client = Clients::first();

        $this->assertEquals('526.683.577-05', $client->cpf);
        $this->assertEquals('Test Name', $client->name);
        $this->assertEquals('Rua teste, nº teste', $client->address);
        $this->assertEquals('15/01/1999',$client->birthdate);
    }

    /** @test */
    public function all_fields_are_required()
    {
        foreach ($this->getFakeData() as $key => $value){
            $data = array_merge($this->getFakeData(), [$key => '']);
            
            $response = $this->post('/api/clients', $data);

            $response->assertSessionHasErrors($key);
        }
        
            $this->assertCount(0, Clients::all());
    }

    /** @test */
    public function cpf_must_be_valid()
    {
        $response = $this->post('/api/clients', 
            array_merge($this->getFakeData(),['cpf' => '000.000.000.00']));

        $response->assertSessionHasErrors('cpf');

        $this->assertCount(0,Clients::all());
    }

    /** @test */
    public function birthdate_follows_ISO8601()
    {
        $this->withoutExceptionHandling();

        $response = $this->post( '/api/clients',
            array_merge($this->getFakeData(),['birthdate' => '15/01/1999']));

        $this->assertCount(1, Clients::all());
        $this->assertInstanceOf(Carbon::class, Clients::first()->birthdate);
        $this->assertEquals('1999-01-15', Clients::first()->birthdate->format('Y-m-d'));
    }

    /** @test */
    public function a_client_can_be_retrieved()
    {
        $client = Clients::factory()->make();

        dd($client);

    }

    private function getFakeData()
    {
        $data = [
            'cpf' => '526.683.577-05',
            'name' => 'Test Name',
            'address' => 'Rua teste, nº teste',
            'birthdate' => '15/01/1999'
        ];

        return $data;
    }
}

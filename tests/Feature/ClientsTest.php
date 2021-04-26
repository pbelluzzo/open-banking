<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Clients;
use App\Models\User;

class ClientsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

    }

    /** @test */
    public function an_unauthenticated_user_should_be_redirected_to_login()
    {
        $response = $this->post('/api/clients', 
            array_merge($this->getFakeData(),['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0,Clients::all());
    }

    /** @test */
    public function a_client_can_be_added_by_authenticated_user()
    {
        $this->withoutExceptionHandling();
        

        $this->post('/api/clients', $this->getFakeData());

        $client = Clients::first();

        $this->assertEquals('526.683.577-05', $client->cpf);
        $this->assertEquals('Test Name', $client->name);
        $this->assertEquals('Rua teste, nº teste', $client->address);
        $this->assertEquals('15/01/1999',$client->birthdate->format('d/m/Y'));
    }

    /** @test */
    public function all_fields_are_required()
    {
        foreach ($this->getFakeData() as $key => $value){
            $data = array_merge($this->getFakeData(), [$key => '']);
           
            if($key == 'api_token') continue;
            
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
    public function a_client_can_be_recovered()
    {
        $client = Clients::factory()->create();
        
        $response = $this->get('/api/clients/' . $client->id . 
            '?api_token=' . $this->user->api_token);

        $response->assertJsonFragment([
            'id' => $client->id,
            'cpf' => $client->cpf,
            'name' => $client->name,
            'address' => $client->address,
            'birthdate' => $client->birthdate
        ]);
    }

    /** @test */
    public function a_client_can_be_patched()
    {
        $this->withoutExceptionHandling();

        $client = Clients::factory()->create();

        $response = $this->patch('/api/clients/' . $client->id, $this->getFakeData());

        $client = $client->fresh();

        $this->assertEquals('526.683.577-05', $client->cpf);
        $this->assertEquals('Test Name', $client->name);
        $this->assertEquals('Rua teste, nº teste', $client->address);
        $this->assertEquals('15/01/1999',$client->birthdate->format('d/m/Y'));
    }

    /** @test */
    public function cpf_must_be_valid_to_patch()
    {
        $client = Clients::factory()->create();

        $response = $this->patch('/api/clients/' . $client->id,
            array_merge($this->getFakeData(),['cpf' => 'NOT A VALID CPF']));
        
        $response->assertSessionHasErrors('cpf');

        $this->assertEquals($client->cpf,Clients::first()->cpf);
        $this->assertEquals($client->name,Clients::first()->name);
        $this->assertEquals($client->address,Clients::first()->address);
        $this->assertEquals($client->birthdate,Clients::first()->birthdate);
    }

    /** @test */
    public function a_client_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $client = Clients::factory()->create();

        $response = $this->delete('/api/clients/' . $client->id,
            ['api_token' => $this->user->api_token]);

        $this->assertCount(0,Clients::all());
    }

    private function getFakeData()
    {
        $data = [
            'cpf' => '526.683.577-05',
            'name' => 'Test Name',
            'address' => 'Rua teste, nº teste',
            'birthdate' => '15/01/1999',
            'api_token' => $this->user->api_token
        ];

        return $data;
    }
}

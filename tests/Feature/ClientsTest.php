<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Clients;
use App\Models\FinancialInstitutions;
use App\Models\User;
use App\Models\Accounts;

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
    public function a_list_of_clients_can_be_recovered_by_the_institution_user()
    {
        //$this->withoutExceptionHandling();

        $institution = FinancialInstitutions::factory()->create();
        $institution2 = FinancialInstitutions::factory()->create();

        $client = Clients::factory()->create();
        $client2 = Clients::factory()->create();

        $account = Accounts::factory()->create(
            [
                'clients_id' => $client->id,
                'financial_institutions_id' => $institution->id,
            ]);      
        $account2 = Accounts::factory()->create(
            [
                'clients_id' => $client->id,
                'financial_institutions_id' => $institution2->id,
            ]);
        $account3 = Accounts::factory()->create(
            [
                'clients_id' => $client2->id,
                'financial_institutions_id' => $institution2->id,
            ]);    
        
        $user = User::factory()->create(
            [
            'entity_type' => 'App\Models\FinancialInstitutions',
            'entity_id' => 1
            ]);
        $anotherUser = User::factory()->create(
            [
                'entity_type' => 'App\Models\Clients',
                'entity_id' => 1
            ]);

        $response = $this->get('/api/clients?api_token=' . $user->api_token);

        $response->assertJsonCount(1)->assertJson([
            'data' => [
                [
                    "data" => [
                        'id' => $client->id,
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function a_client_cannot_recover_a_list_of_clients()
    {
        $client = Clients::factory()->create();
        $anotherUser = User::factory()->create(
            [
                'entity_type' => 'App\Models\Clients',
                'entity_id' => 1
            ]);
        $response = $this->get('/api/clients?api_token=' . $anotherUser->api_token);
        
        $response->assertStatus(403);
    }
    
    /** @test */
    public function a_client_can_be_added_by_authenticated_user()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/clients', $this->getFakeData());
        
        $client = Clients::first();
        
        $this->assertEquals('526.683.577-05', $client->cpf);
        $this->assertEquals('Test Name', $client->name);
        $this->assertEquals('Rua teste, nº teste', $client->address);
        $this->assertEquals('15/01/1999',$client->birthdate);
        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'id' => $client->id
            ],
            'links' => [
                'self' => url('/clients/' . $client->id)
            ]
        ]);
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
    public function a_client_cannot_recover_a_client()
    {
        $client = Clients::factory()->create();
        $client2 = Clients::factory()->create();
        $anotherUser = User::factory()->create(
            [
                'entity_type' => 'App\Models\Clients',
                'entity_id' => 1
            ]);
        
        $response = $this->get('/api/clients/' . $client2->id . '?api_token=' . $anotherUser->api_token);
        
        $response->assertStatus(403);
    }    

    /** @test */
    public function a_client_can_be_recovered_by_institution_user()
    {
        $this->withoutExceptionHandling();

        $client = Clients::factory()->create();
        $institution = FinancialInstitutions::factory()->create();
        $anotherUser = User::factory()->create(
            [
                'entity_type' => 'App\Models\FinancialInstitutions',
                'entity_id' => 1
            ]
        );        
        $response = $this->get('/api/clients/' . $client->id . 
            '?api_token=' . $anotherUser->api_token);

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
        $this->assertEquals('15/01/1999',$client->birthdate);
        $response->assertStatus(200);
        $response->assertJson( [
            'data' => [
                'id' => $client->id,
            ],
            'links' => [
                'self' => $client->path(),
            ]
        ]);
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
        $response->assertStatus(204);
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

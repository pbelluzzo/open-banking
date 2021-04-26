<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Contracts;
use App\Models\User;

class ContractsTest extends TestCase
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
        $response = $this->post('/api/contracts', 
            array_merge($this->getFakeData(),['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0,Contracts::all());
    }

    /** @test */
    public function a_contract_can_be_added_by_authenticated_user()
    {
        $this->withoutExceptionHandling();

        $this->post('/api/contracts', $this->getFakeData());

        $contract = Contracts::first();

        $this->assertCount(1,Contracts::all());        
        $this->assertEquals(1, $contract->account_id);
        $this->assertEquals(1, $contract->product_id);
        $this->assertEquals(333.42, $contract->amount_invested);
        $this->assertEquals(04.22, $contract->administration_fee);
        $this->assertEquals('09/04/2021', $contract->hiring_date->format('d/m/Y'));
        $this->assertEquals(0, $contract->finished);

    }

    /** @test */
    public function all_contract_fields_are_required()
    {
        foreach ($this->getFakeData() as $key => $value){
            $data = array_merge($this->getFakeData(), [$key => '']);
            
            if($key == 'api_token') continue;

            $response = $this->post('/api/contracts', $data);

            $response->assertSessionHasErrors($key);
        }
        
            $this->assertCount(0, Contracts::all());
    }

     /** @test */
    public function a_contract_can_be_recovered()
    {
        //$this->withoutExceptionHandling();
 
        $contract = Contracts::factory()->create();
             
        $response = $this->get('/api/contracts/' . $contract->id . '?api_token=' .
            $this->user->api_token);
 
        $response->assertJsonFragment([
            'id' => $contract->id,
            'account_id' => $contract->account_id,
            'product_id' => $contract->product_id,
            'amount_invested' => $contract->amount_invested,
            'administration_fee' => $contract->administration_fee,
            'hiring_date' => $contract->hiring_date,
            'finished' => $contract->finished
        ]);
    }

    /** @test */
    public function a_contract_can_be_patched()
    {
        $this->withoutExceptionHandling();

        $contract = Contracts::factory()->create();

        $response = $this->patch('/api/contracts/' . $contract->id, $this->getFakeData());

        $contract = $contract->fresh();

        $this->assertEquals(1, $contract->account_id);
        $this->assertEquals(1, $contract->product_id);
        $this->assertEquals(333.42, $contract->amount_invested);
        $this->assertEquals(04.22, $contract->administration_fee);
        $this->assertEquals('09/04/2021', $contract->hiring_date->format('d/m/Y'));
        $this->assertEquals(0, $contract->finished);
    }
    
    /** @test */
    public function a_contract_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $contract = Contracts::factory()->create();

        $response = $this->delete('/api/contracts/' . $contract->id, 
            ['api_token' => $this->user->api_token]);

        $this->assertCount(0,Contracts::all());
    }    

    private function getFakeData()
    {
        return [
            'account_id' => 1,
            'product_id' => 1,
            'amount_invested' => 333.42,
            'administration_fee' => 04.22,
            'hiring_date' => '09/04/2021',
            'finished' => 0,
            'api_token' => $this->user->api_token
        ];
    }
}

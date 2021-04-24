<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Accounts;

class AccountsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_account_can_be_added()
    {
        $this->withoutExceptionHandling();

        $this->post('/api/accounts', $this->getFakeData());

        $account = Accounts::first();

        $this->assertCount(1,Accounts::all());
        $this->assertEquals('1', $account->client_id);
        $this->assertEquals('1', $account->institution_id);
        $this->assertEquals(1555.22, $account->balance);
        $this->assertEquals(null, $account->ended_in);

    }

    /** @test */
    public function some_fields_are_required()
    {
        foreach ($this->getFakeData() as $key => $value){
            $data = array_merge($this->getFakeData(), [$key => '']);

            if($key == 'ended_in') continue;
                       
            $response = $this->post('/api/accounts', $data);

            $response->assertSessionHasErrors($key);
        }
        
            $this->assertCount(0, Accounts::all());
    }

     /** @test */
    public function an_account_can_be_recovered()
    {
        $this->withoutExceptionHandling();

        $account = Accounts::factory()->create();
            
        $response = $this->get('/api/accounts/' . $account->id);

        $response->assertJsonFragment([
            'id' => $account->id,
            'client_id' => $account->client_id,
            'institution_id' => $account->institution_id,
            'balance' => $account->balance,
            'ended_in' => $account->ended_in
        ]);
    }
    
    /** @test */
    public function an_account_can_be_patched()
    {
        $this->withoutExceptionHandling();

        $account = Accounts::factory()->create();

        $response = $this->patch('/api/accounts/' . $account->id, $this->getFakeData());

        $account = $account->fresh();

        $this->assertEquals('1', $account->client_id);
        $this->assertEquals('1', $account->institution_id);
        $this->assertEquals(1555.22, $account->balance);
        $this->assertEquals(null, $account->ended_in);
    }    

    /** @test */
    public function an_account_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $account = Accounts::factory()->create();

        $response = $this->delete('/api/accounts/' . $account->id);

        $this->assertCount(0,Accounts::all());
    }

    private function getFakeData()
    {
        return [
            'client_id' => 1,
            'institution_id' => 1,
            'balance' => 1555.22,
            'ended_in' => null
        ];
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Accounts;
use App\Models\User;

class AccountsTest extends TestCase
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
        $response = $this->post('/api/accounts', 
            array_merge($this->getFakeData(),['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0,Accounts::all());
    }

    /** @test */
    public function an_account_can_be_added_by_authenticated_user()
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

            if($key == 'api_token') continue;
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
            
        $response = $this->get('/api/accounts/' . $account->id . '?api_token=' .
            $this->user->api_token);

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

        $response = $this->delete('/api/accounts/' . $account->id, 
            ['api_token' => $this->user->api_token]);

        $this->assertCount(0,Accounts::all());
    }

    private function getFakeData()
    {
        return [
            'client_id' => 1,
            'institution_id' => 1,
            'balance' => 1555.22,
            'ended_in' => null,
            'api_token' => $this->user->api_token
        ];
    }
}

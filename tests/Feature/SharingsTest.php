<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Sharings;
use App\Models\User;

class SharingsTest extends TestCase
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
        $response = $this->post('/api/sharings', 
            array_merge($this->getFakeData(),['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0,Sharings::all());
    }

    /** @test */
    public function a_sharing_can_be_added_by_authenticated_user()
    {
        $this->withoutExceptionHandling();

        $this->post('/api/sharings', $this->getFakeData());

        $sharing = Sharings::first();

        $this->assertCount(1,Sharings::all());
        $this->assertEquals(1, $sharing->client_id);
        $this->assertEquals(1, $sharing->origin_institution_id);
        $this->assertEquals(3, $sharing->destiny_institution_id);
        $this->assertEquals('', $sharing->acceptance_date);
        $this->assertEquals('', $sharing->xml_path);
    }
    
    /** @test */
    public function some_sharing_fields_are_required()
    {
        foreach ($this->getFakeData() as $key => $value){
            $data = array_merge($this->getFakeData(), [$key => '']);

            if($key == 'api_token') continue;
            if($key == 'acceptance_date') continue;
            if($key == 'xml_path') continue;
                       
            $response = $this->post('/api/sharings', $data);

            $response->assertSessionHasErrors($key);
        }
        
            $this->assertCount(0, Sharings::all());
    }
    
     /** @test */
    public function a_sharing_can_be_recovered()
    {
        //$this->withoutExceptionHandling();
 
        $sharing = Sharings::factory()->create();
             
        $response = $this->get('/api/sharings/' . $sharing->id . '?api_token=' .
            $this->user->api_token);
 
        $response->assertJsonFragment([
            'id' => $sharing->id,
            'client_id' => $sharing->client_id,
            'origin_institution_id' => $sharing->origin_institution_id,
            'destiny_institution_id' => $sharing->destiny_institution_id,
            'acceptance_date' => $sharing->acceptance_date,
            'xml_path' => $sharing->xml_path
        ]);
    }
    
    /** @test */
    public function a_sharing_can_be_patched()
    {
        $this->withoutExceptionHandling();

        $sharing = Sharings::factory()->create();

        $response = $this->patch('/api/sharings/' . $sharing->id, $this->getFakeData());

        $sharing = $sharing->fresh();

        $this->assertEquals(1, $sharing->client_id);
        $this->assertEquals(1, $sharing->origin_institution_id);
        $this->assertEquals(3, $sharing->destiny_institution_id);
        $this->assertEquals('', $sharing->acceptance_date);
        $this->assertEquals('', $sharing->xml_path);
    }
    
    /** @test */
    public function a_sharing_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $sharing = Sharings::factory()->create();

        $response = $this->delete('/api/sharings/' . $sharing->id, 
            ['api_token' => $this->user->api_token]);

        $this->assertCount(0,Sharings::all());
    }    

    private function getFakeData()
    {
        return [
            'client_id' => 1,
            'origin_institution_id' => 1,
            'destiny_institution_id' => 3,
            'acceptance_date' => '',
            'xml_path' => '',
            'api_token' => $this->user->api_token
        ];
    }    
}

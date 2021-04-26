<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\FinancialProducts;
use App\Models\User;

class FinancialProductsTest extends TestCase
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
        $response = $this->post('/api/financial_products', 
            array_merge($this->getFakeData(),['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0,FinancialProducts::all());
    }

    /** @test */
    public function a_product_can_be_added_by_authenticated_user()
    {
        $this->withoutExceptionHandling();

        $this->post('/api/financial_products', $this->getFakeData());

        $product = FinancialProducts::first();

        $this->assertCount(1,FinancialProducts::all());
        $this->assertEquals('1', $product->institution_id);
        $this->assertEquals('Titulo de fakaptalização', $product->description);
        $this->assertEquals(555.22, $product->minimum_value);
        $this->assertEquals(03.55, $product->administration_fee);

    }

    /** @test */
    public function all_product_fields_are_required()
    {
        foreach ($this->getFakeData() as $key => $value){
            $data = array_merge($this->getFakeData(), [$key => '']);

            if($key == 'api_token') continue;
                               
            $response = $this->post('/api/financial_products', $data);
    
            $response->assertSessionHasErrors($key);
        }
            
        $this->assertCount(0, FinancialProducts::all());
    }

    /** @test */
    public function a_product_can_be_recovered()
    {
        $this->withoutExceptionHandling();
 
        $product = FinancialProducts::factory()->create();
             
        $response = $this->get('/api/financial_products/' . $product->id . '?api_token=' .
            $this->user->api_token);

        $response->assertJsonFragment([
            'id' => $product->id,
            'institution_id' => $product->institution_id,
            'description' => $product->description,
            'minimum_value' => $product->minimum_value,
            'administration_fee' => $product->administration_fee
        ]);
    }

    /** @test */
    public function a_product_can_be_patched()
    {
        $this->withoutExceptionHandling();

        $product = FinancialProducts::factory()->create();

        $response = $this->patch('/api/financial_products/' . $product->id, $this->getFakeData());

        $product = $product->fresh();

        $this->assertEquals('1', $product->institution_id);
        $this->assertEquals('Titulo de fakaptalização', $product->description);
        $this->assertEquals(555.22, $product->minimum_value);
        $this->assertEquals(03.55, $product->administration_fee);
    }      

    /** @test */
    public function a_product_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $product = FinancialProducts::factory()->create();

        $response = $this->delete('/api/financial_products/' . $product->id, 
            ['api_token' => $this->user->api_token]);

        $this->assertCount(0,FinancialProducts::all());
    }    

    private function getFakeData()
    {
        return [
            'institution_id' => '1',
            'description' => 'Titulo de fakaptalização',
            'minimum_value' => 555.22,
            'administration_fee' => 03.55,
            'api_token' => $this->user->api_token
        ];
    }    

}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\FinancialProducts;

class FinancialProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_product_can_be_added()
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
             
        $response = $this->get('/api/financial_products/' . $product->id);

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

        $response = $this->delete('/api/financial_products/' . $product->id);

        $this->assertCount(0,FinancialProducts::all());
    }    

    private function getFakeData()
    {
        return [
            'institution_id' => '1',
            'description' => 'Titulo de fakaptalização',
            'minimum_value' => 555.22,
            'administration_fee' => 03.55,
        ];
    }    

}

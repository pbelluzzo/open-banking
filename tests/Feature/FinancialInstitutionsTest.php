<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\FinancialInstitutions;
use Tests\TestCase;

class FinancialInstitutionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_institution_can_be_added()
    {
        $this->withoutExceptionHandling();

        $this->post('/api/financial_institutions', $this->getFakeData());

        $institution = FinancialInstitutions::first();

        $this->assertCount(1,FinancialInstitutions::all());
        $this->assertEquals('56.049.352/0001-96', $institution->cnpj);
        $this->assertEquals('Empresa top ltda.', $institution->company_name);
        $this->assertEquals('Caçadores de dragões', $institution->fantasy_name);
        $this->assertEquals('7070', $institution->bank_code);

    }

    /** @test */
    public function all_fields_are_required()
    {
        foreach ($this->getFakeData() as $key => $value){
            $data = array_merge($this->getFakeData(), [$key => '']);
                       
            $response = $this->post('/api/financial_institutions', $data);

            $response->assertSessionHasErrors($key);
        }
        
            $this->assertCount(0, FinancialInstitutions::all());
    }

    /** @test */
    public function cnpj_must_be_valid()
    {
        $response = $this->post('/api/financial_institutions', 
            array_merge($this->getFakeData(),['cnpj' => 'NOT A VALID CNPJ']));

        $response->assertSessionHasErrors('cnpj');

        $this->assertCount(0,FinancialInstitutions::all());
    }

    /** @test */
    public function an_institution_can_be_recovered()
    {
        $this->withoutExceptionHandling();

        $institution = FinancialInstitutions::factory()->create();
            
        $response = $this->get('/api/financial_institutions/' . $institution->id);
    
        $response->assertJsonFragment([
            'id' => $institution->id,
            'cnpj' => $institution->cnpj,
            'company_name' => $institution->company_name,
            'fantasy_name' => $institution->fantasy_name,
            'bank_code' => $institution->bank_code
        ]);
    }

    /** @test */
    public function an_institution_can_be_patched()
    {
        $this->withoutExceptionHandling();

        $institution = FinancialInstitutions::factory()->create();

        $response = $this->patch('/api/financial_institutions/' . $institution->id, $this->getFakeData());

        $institution = $institution->fresh();

        $this->assertEquals('56.049.352/0001-96', $institution->cnpj);
        $this->assertEquals('Empresa top ltda.', $institution->company_name);
        $this->assertEquals('Caçadores de dragões', $institution->fantasy_name);
        $this->assertEquals('7070', $institution->bank_code);
    }

    /** @test */
    public function cnpj_must_be_valid_to_patch()
    {
        $institution = FinancialInstitutions::factory()->create();

        $response = $this->patch('/api/financial_institutions/' . $institution->id,
            array_merge($this->getFakeData(),['cnpj' => 'NOT A VALID CNPJ']));
        
        $response->assertSessionHasErrors('cnpj');

        $this->assertEquals($institution->cnpj,FinancialInstitutions::first()->cnpj);
        $this->assertEquals($institution->company_name,FinancialInstitutions::first()->company_name);
        $this->assertEquals($institution->fantasy_name,FinancialInstitutions::first()->fantasy_name);
        $this->assertEquals($institution->bank_code,FinancialInstitutions::first()->bank_code);
    }    

    /** @test */
    public function an_institution_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $institution = FinancialInstitutions::factory()->create();

        $response = $this->delete('/api/financial_institutions/' . $institution->id);

        $this->assertCount(0,FinancialInstitutions::all());
    }

    private function getFakeData()
    {
        return [
            'cnpj' => '56.049.352/0001-96',
            'company_name' => 'Empresa top ltda.',
            'fantasy_name' => 'Caçadores de dragões',
            'bank_code' => '7070'
        ];
    }
}

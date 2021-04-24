<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Contracts;

class ContractsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_contract_can_be_added()
    {
        $this->withoutExceptionHandling();

        $this->post('/api/contracts', $this->getFakeData());

        $contract = Contracts::first();

        $this->assertCount(1,Contracts::all());
        $this->assertEquals(1, $contract->account_id);
        $this->assertEquals(1, $contract->product_id);
        $this->assertEquals(333.42, $contract->ammount_invested);
        $this->assertEquals('2021-04-05', $contract->hiring_date);
        $this->assertEquals(0, $contract->finished);

    }

    private function getFakeData()
    {
        return [
            'account_id' => 1,
            'product_id' => 1,
            'ammount_invested' => 333.42,
            'hiring_date' => '05/04/2021',
            'finished' => 0,
        ];
    }
}

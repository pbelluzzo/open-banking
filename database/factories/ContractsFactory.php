<?php

namespace Database\Factories;

use App\Models\Contracts;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contracts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => random_int(1,999),
            'product_id' => random_int(1,999),
            'amount_invested' => (float)(random_int(10000,999999)/100),
            'administration_fee' => (float)(random_int(100,500)/100),
            'hiring_date' => $this->faker->date('d/m/Y'),
            'finished' => 0,
        ];
    }
}

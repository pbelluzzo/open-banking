<?php

namespace Database\Factories;

use App\Models\FinancialInstitutions;
use Illuminate\Database\Eloquent\Factories\Factory;

class FinancialInstitutionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FinancialInstitutions::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cnpj' => $this->faker->cnpj(),
            'company_name' => $this->faker->company(),
            'fantasy_name' => 'Fake Fantasy Name!',
            'bank_code' => (string)random_int(111,999)
        ];
    }
}

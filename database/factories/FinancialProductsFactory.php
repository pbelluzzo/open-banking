<?php

namespace Database\Factories;

use App\Models\FinancialProducts;
use Illuminate\Database\Eloquent\Factories\Factory;

class FinancialProductsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FinancialProducts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'institution_id' => '1',
            'description' => 'fake product description',
            'minimum_value' => (float)(random_int(100,10000)/100),
            'administration_fee' => (float)(random_int(55,500)/100),
        ];
    }
}

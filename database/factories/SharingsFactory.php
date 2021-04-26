<?php

namespace Database\Factories;

use App\Models\Sharings;
use Illuminate\Database\Eloquent\Factories\Factory;

class SharingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sharings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_id' => random_int(1,999),
            'origin_institution_id' => random_int(1,999),
            'destiny_institution_id' => random_int(1,999),
            'acceptance_date' => $this->faker->date('d/m/Y'),
            'xml_path' => 'simulation'
        ];
    }
}

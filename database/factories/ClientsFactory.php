<?php

namespace Database\Factories;

use App\Models\Clients;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Clients::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cpf' => '526.683.577-05',
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'birthdate' => $this->faker->date('d/m/Y')
        ];
    }
}

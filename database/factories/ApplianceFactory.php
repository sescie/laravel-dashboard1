<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appliance>
 */
class ApplianceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "id"=> 9,
            'name' => $this->faker->name,
            'Port_Number' => $this->faker->numberBetween(1,10),
            'Running'=> $this->faker->boolean,
            'Top_Priority'=> $this->faker->boolean,

        ];
    }
}

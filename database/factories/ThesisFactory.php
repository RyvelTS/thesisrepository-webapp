<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThesisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'title' => $this->faker->sentence(),
          'user_id' => User::pluck('id')->random(),
          'supervisor_name' => $this->faker->name(),
        ];
    }
}

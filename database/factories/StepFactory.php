<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Step>
 */
class StepFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      "vorname" => fake()->name(),
      "name" => fake()->name(),
      "klasse" => fake()->randomDigitNotZero(),
      "von" => fake()
        ->dateTimeBetween("-1 week", "+1 week")
        ->format("Y-m-d"),
      "bis" => fake()
        ->dateTimeBetween("-1 week", "+1 week")
        ->format("Y-m-d"),
      "schritte" => fake()->numberBetween(100, 500),
    ];
  }
}

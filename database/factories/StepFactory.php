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
    // $klasse_stufe = fake()->numberBetween(5, 12);
    // $klasse_nr = fake()->regexify("[a-c]");

    return [
        // "vorname" => fake()->firstname(),
        // "name" => fake()->lastname(),
        // "klasse" => $klasse_stufe . $klasse_nr,
        // "von" => fake()
        //   ->dateTimeBetween("-2 day", "-1 day")
        //   ->format("Y-m-d"),
        // "bis" => fake()
        //   ->dateTimeBetween("+1 day", "+2 day")
        //   ->format("Y-m-d"),
        // "schritte" => fake()->numberBetween(100, 500),
      ];
  }
}

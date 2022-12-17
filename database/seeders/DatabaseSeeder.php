<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $faker = app(Generator::class);

    // \App\Models\User::factory(10)->create();

    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);

    // \App\Models\Step::factory(50)->create();

    $anzahl = 50;
    $wahrscheinlichkeit = 50;
    $von = ["2022-01-01", "2022-01-08", "2022-01-15", "2022-01-22"];
    $bis = ["2022-01-07", "2022-01-14", "2022-01-21", "2022-01-28"];

    foreach (range(1, $anzahl) as $_) {
      $vorname = $faker->firstname();
      $name = $faker->lastname();
      $klasse_stufe = fake()->numberBetween(5, 12);
      $klasse_nr = fake()->regexify("[a-c]");
      $klasse = $klasse_stufe . $klasse_nr;

      for ($i = 0; $i < count($von); $i++) {
        if (rand(0, 100) < $wahrscheinlichkeit) {
          \App\Models\Step::factory()->create([
            "vorname" => $vorname,
            "name" => $name,
            "klasse" => $klasse,
            "von" => $von[$i],
            "bis" => $bis[$i],
            "schritte" => $faker->numberBetween(100, 500),
          ]);
        }
      }
    }
  }
}

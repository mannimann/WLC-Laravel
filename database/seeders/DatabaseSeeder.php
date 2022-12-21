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

    $von = [
      "2023-01-02T00:00:00.000Z",
      "2023-01-09T00:00:00.000Z",
      "2023-01-16T00:00:00.000Z",
      "2023-01-23T00:00:00.000Z",
    ];
    $bis = [
      "2023-01-08T00:00:00.000Z",
      "2023-01-15T00:00:00.000Z",
      "2023-01-22T00:00:00.000Z",
      "2023-01-29T00:00:00.000Z",
    ];

    /*
     * Steps
     */
    $anzahl = 50;
    $wahrscheinlichkeit = 50;

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

    /*
     * Klassen
     */
    foreach (range(5, 12) as $stufe) {
      foreach (["a", "b", "c"] as $nr) {
        \App\Models\Klasse::factory()->create([
          "klasse" => $stufe . $nr,
        ]);
      }
    }

    /*
     * Zeiträume
     */
    for ($i = 0; $i < count($von); $i++) {
      \App\Models\Zeitraum::factory()->create([
        "von" => $von[$i],
        "bis" => $bis[$i],
      ]);
    }
  }
}

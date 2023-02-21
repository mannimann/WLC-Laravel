<?php

namespace Database\Seeders;

use App\Models\Step;
use App\Models\Klasse;
use App\Models\Zeitraum;
use Faker\Generator;
use Illuminate\Database\Seeder;

class StepSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $faker = app(Generator::class);

    /*
     * Zeiträume
     */
    $zeiträume = collect(Zeitraum::select("von", "bis")->get());
    if (count($zeiträume) == 0) {
      $zeiträume = [
        [
          "von" => "2023-01-02T00:00:00.000Z",
          "bis" => "2023-01-08T00:00:00.000Z",
        ],
        [
          "von" => "2023-01-09T00:00:00.000Z",
          "bis" => "2023-01-15T00:00:00.000Z",
        ],
        [
          "von" => "2023-01-16T00:00:00.000Z",
          "bis" => "2023-01-22T00:00:00.000Z",
        ],
        [
          "von" => "2023-01-23T00:00:00.000Z",
          "bis" => "2023-01-29T00:00:00.000Z",
        ],
      ];

      for ($i = 0; $i < count($zeiträume); $i++) {
        Zeitraum::factory()->create([
          "von" => $zeiträume[$i]["von"],
          "bis" => $zeiträume[$i]["bis"],
        ]);
      }
    }

    /*
     * Klassen
     */
    $klassen = collect(
      Klasse::select("klasse")
        ->get()
        ->pluck("klasse")
    );
    if (count($klassen) == 0) {
      $klassen = [];
      foreach (range(5, 12) as $stufe) {
        foreach (["a", "b", "c"] as $nr) {
          Klasse::factory()->create([
            "klasse" => $stufe . $nr,
          ]);
          $klassen[] = $stufe . $nr;
        }
      }
      Klasse::factory()->create([
        "klasse" => "Lehrer",
      ]);
      $klassen[] = "Lehrer";
      Klasse::factory()->create([
        "klasse" => "Eltern",
      ]);
      $klassen[] = "Eltern";
    }

    /*
     * Steps
     */
    $anzahl = 135;
    $wahrscheinlichkeit = 70;

    foreach (range(1, $anzahl) as $_) {
      $vorname = $faker->firstname();
      $name = $faker->lastname();
      $klasse = $klassen[rand(0, count($klassen) - 1)];

      for ($i = 0; $i < count($zeiträume); $i++) {
        if (rand(0, 100) < $wahrscheinlichkeit) {
          $schritte = $faker->numberBetween(20000, 130000);

          Step::factory()->create([
            "vorname" => $vorname,
            "name" => $name,
            "klasse" => $klasse,
            "von" => $zeiträume[$i]["von"],
            "bis" => $zeiträume[$i]["bis"],
            "schritte" => $schritte,
            "screenshot" => $faker->imageUrl(640, 640, $schritte, false),
          ]);
        }
      }
    }
  }
}

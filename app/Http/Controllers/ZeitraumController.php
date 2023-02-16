<?php

namespace App\Http\Controllers;

use App\Models\Zeitraum;
use Illuminate\Http\Request;

class ZeitraumController extends Controller
{
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validated = $request->validate(
      [
        "von" => "required|date",
        "bis" => "required|date",
      ],
      [
        "von.required" => "Zeitraum muss ausgefüllt werden.",
        "bis.required" => "Zeitraum muss ausgefüllt werden.",
        "von.date" => "Zeitraum muss ein gültiges Datum sein.",
        "bis.date" => "Zeitraum muss ein gültiges Datum sein.",
      ]
    );

    $zeiträume = Zeitraum::select("von", "bis")->get();
    foreach ($zeiträume as $zr) {
      if (
        ($validated["von"] >= $zr["von"] && $validated["von"] <= $zr["bis"]) ||
        ($validated["bis"] >= $zr["von"] && $validated["bis"] <= $zr["bis"])
      ) {
        return redirect()
          ->back()
          ->withErrors([
            "message" => "Zeiträume überschneiden sich!",
            "status" => "error",
          ]);
      }
    }

    $zeitraum = Zeitraum::firstOrCreate($validated);

    if ($zeitraum->wasRecentlyCreated) {
      return redirect()
        ->back()
        ->with(["message" => "Zeitraum hinzugefügt!"]);
    } else {
      return redirect()
        ->back()
        ->withErrors([
          "message" => "Zeitraum bereits vorhanden!",
          "status" => "warning",
        ]);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Zeitraum  $zeitraum
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Zeitraum $zeitraum)
  {
    $validated = $request->validate([
      "von" => "required|date",
      "bis" => "required|date",
    ]);

    $zeitraum->update($validated);

    return redirect()
      ->back()
      ->with(["message" => "Zeitraum erfolgreich geändert"]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Zeitraum  $zeitraum
   * @return \Illuminate\Http\Response
   */
  public function destroy(Zeitraum $zeitraum)
  {
    $zeitraum->delete();

    return redirect()
      ->back()
      ->with(["message" => "Zeitraum erfolgreich gelöscht"]);
  }
}

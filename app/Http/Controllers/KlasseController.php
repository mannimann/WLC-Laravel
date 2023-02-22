<?php

namespace App\Http\Controllers;

use App\Models\Klasse;
use Illuminate\Http\Request;

class KlasseController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      "klasse" => "required|string|max:10",
      "kategorie" => "required|string|max:15|in:Schüler,Erwachsene",
    ]);

    $klasse_count = Klasse::where("klasse", "=", $validated["klasse"])->count();

    if ($klasse_count > 0) {
      return redirect()
        ->back()
        ->withErrors([
          "message" => "Klasse bereits vorhanden!",
        ]);
    }

    Klasse::create($validated);

    return redirect()
      ->back()
      ->with(["message" => "Klasse hinzugefügt!"]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Klasse  $klasse
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Klasse $klasse)
  {
    $validated = $request->validate([
      "klasse" => "required|string|max:10",
      "kategorie" => "required|string|max:15|in:Schüler,Erwachsene",
    ]);

    $klasse_old = Klasse::where("klasse", "=", $validated["klasse"])
      ->limit(1)
      ->get();

    if (
      count($klasse_old) > 0 &&
      ($klasse["id"] != $klasse_old[0]["id"] ||
        $klasse_old[0]["kategorie"] == $validated["kategorie"])
    ) {
      return redirect()
        ->back()
        ->withErrors([
          "message" => "Klasse bereits vorhanden!",
        ]);
    }

    $klasse->update($validated);

    return redirect()
      ->back()
      ->with(["message" => "Klasse erfolgreich geändert"]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Klasse  $klasse
   * @return \Illuminate\Http\Response
   */
  public function destroy(Klasse $klasse)
  {
    $klasse->delete();

    return redirect()
      ->back()
      ->with(["message" => "Klasse erfolgreich gelöscht"]);
  }
}

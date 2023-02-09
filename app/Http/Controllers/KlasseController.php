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
    // return Inertia::render("Klasse/Index", [
    //   "klassen" => Klasse::all(),
    // ]);
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
    ]);
    Klasse::create($validated);

    return redirect()
      ->back()
      ->with(["message" => "Klasse erfolgreich erstellt"]);
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
    ]);

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
      ->with(["message" => "Klasse erfolgreich gelöschtt"]);
  }
}

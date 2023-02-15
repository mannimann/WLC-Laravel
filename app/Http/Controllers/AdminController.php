<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Inertia\Inertia;
use App\Models\Klasse;
use App\Models\Zeitraum;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;

class AdminController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $settings = Valuestore::make(
      storage_path("../database/database/settings.json")
    );

    $klassen = Klasse::orderByRaw("LENGTH(klasse) ASC")
      ->orderBy("klasse")
      ->get();
    $zeiträume = Zeitraum::orderBy("von")
      ->orderBy("bis")
      ->get();

    return Inertia::render("Admin/Index", [
      "settings.title" => $settings->get("title"),
      "klassen" => $klassen,
      "zeiträume" => $zeiträume,
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy()
  {
    Step::truncate();

    return redirect()
      ->back()
      ->with(["message" => "Alle Daten gelöscht"]);
  }
}

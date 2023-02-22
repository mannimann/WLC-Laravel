<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Inertia\Inertia;
use App\Models\Zeitraum;
use Illuminate\Http\Request;
use App\Services\StepService;
use Spatie\Valuestore\Valuestore;

class AuswertungController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $steps = new StepService();

    $settings = Valuestore::make(
      storage_path("../database/database/settings.json")
    );

    $zeiträume = Zeitraum::select("von", "bis")
      ->orderBy("von")
      ->orderBy("bis")
      ->get();

    /*
     * Alle Daten
     */
    $steps_all = $steps->get_all();

    /*
     * Steps gruppiert nach Zeiträumen
     */
    $steps_zeitraum = $steps->get_steps_zeitraum();

    /*
     * Steps der besten Schüler
     */
    $steps_läufer_schüler = $steps->get_steps_läufer_schüler();

    /*
     * Steps der besten Erwachsenen
     */
    $steps_läufer_erwachsene = $steps->get_steps_läufer_erwachsene();

    /*
     * Steps gruppiert nach Klassen
     */
    $steps_klassen = $steps->get_steps_klassen();

    /*
     * Steps gruppiert nach Läufer (Alle Läufer)
     */
    $steps_läufer_zeitraum = $steps->get_steps_läufer_zeitraum();

    return Inertia::render("Auswertung/Index", [
      "settings.title" => $settings->get("title"),
      "steps_all" => $steps_all,
      "steps_zeitraum" => $steps_zeitraum,
      "steps_läufer_schüler" => $steps_läufer_schüler,
      "steps_läufer_erwachsene" => $steps_läufer_erwachsene,
      "steps_klassen" => $steps_klassen,
      "steps_läufer_zeitraum" => $steps_läufer_zeitraum,
      "zeiträume" => $zeiträume,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
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
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Step  $step
   * @return \Illuminate\Http\Response
   */
  public function show(Step $step)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Step  $step
   * @return \Illuminate\Http\Response
   */
  public function edit(Step $step)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Step  $step
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Step $step)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Step  $step
   * @return \Illuminate\Http\Response
   */
  public function destroy(Step $step)
  {
    //
  }
}

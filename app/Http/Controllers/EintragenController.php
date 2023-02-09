<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Inertia\Inertia;
use App\Models\Klasse;
use App\Models\Zeitraum;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;
use App\Http\Requests\StoreStepRequest;

class EintragenController extends Controller
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

    $klassen = Klasse::select("klasse")
      ->orderByRaw("LENGTH(klasse) ASC")
      ->get();
    $zeiträume = Zeitraum::select("von", "bis")->get();

    return Inertia::render("Eintragen/Index", [
      "settings" => $settings->all(),
      "klassen" => $klassen->values(),
      "zeiträume" => $zeiträume->values(),
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
  public function store(StoreStepRequest $request)
  {
    $duplicate = Step::Where("vorname", $request->vorname)
      ->where("name", $request->name)
      ->where("klasse", $request->klasse)
      ->where("von", $request->von)
      ->where("bis", $request->bis)
      ->count();

    if ($duplicate > 0) {
      return redirect()
        ->back()
        ->withErrors([
          "message" => "Du hast dich für diesen Zeitraum bereits eingetragen!",
        ]);
    }

    Step::create($request->validated());
    return redirect()
      ->back()
      ->with(["message" => "Daten erfolgreich eingetragen"]);
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

<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Inertia\Inertia;
use App\Models\Zeitraum;
use Illuminate\Http\Request;
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
    $settings = Valuestore::make(
      storage_path("../database/database/settings.json")
    );

    /*
     * Alle Daten
     */
    $steps_all = Step::get();

    /*
     * Steps gruppiert nach Zeiträumen
     */
    $zeiträume = Zeitraum::select("von", "bis")
      ->orderBy("von")
      ->orderBy("bis")
      ->get();

    $steps_zeitraum = [];
    foreach ($zeiträume as $z) {
      $sz = Step::select(
        Step::raw("SUM(schritte) AS schritte_sum"),
        Step::raw("COUNT(id) AS teilnehmer_count"),
        Step::raw("SUM(schritte)/COUNT(id) AS schritte_pro_kopf")
      )
        ->where("von", "=", $z->von)
        ->where("bis", "=", $z->bis)
        ->get();

      $zd =
        date_format(date_create($z->von), "d.m.y") .
        " - " .
        date_format(date_create($z->bis), "d.m.y");
      $steps_zeitraum[] = [
        "zeitraum" => $zd,
        "schritte_sum" => $sz[0]->schritte_sum > 0 ? $sz[0]->schritte_sum : 0,
        "teilnehmer_count" =>
          $sz[0]->teilnehmer_count > 0 ? $sz[0]->teilnehmer_count : 0,
        "schritte_pro_kopf" =>
          $sz[0]->schritte_pro_kopf > 0 ? $sz[0]->schritte_pro_kopf : 0,
      ];
    }

    // Footer bzw. Zeile Gesamt
    // TODO
    if ($steps_zeitraum > 0) {
      $zeitraum_sub = Step::select(
        Step::raw("COUNT(*) AS 'teilnehmer_count'")
      )->fromSub(function ($query) {
        $query->from("steps")->groupBy("vorname", "name", "klasse");
      }, "s");

      $zeitraum_gesamt = Step::select(
        Step::raw("SUM(schritte) AS schritte_sum"),
        Step::raw("teilnehmer_count"),
        Step::raw("SUM(schritte)/COUNT(id) AS schritte_pro_kopf")
      )
        ->joinSub($zeitraum_sub, "steps2", Step::raw(1), "=", Step::raw(1))
        ->get();

      $steps_zeitraum[] = [
        "zeitraum" => "Gesamt",
        "schritte_sum" =>
          $zeitraum_gesamt[0]->schritte_sum > 0
            ? $zeitraum_gesamt[0]->schritte_sum
            : 0,
        "teilnehmer_count" =>
          $zeitraum_gesamt[0]->teilnehmer_count > 0
            ? $zeitraum_gesamt[0]->teilnehmer_count
            : 0,
        "schritte_pro_kopf" =>
          $zeitraum_gesamt[0]->schritte_pro_kopf > 0
            ? $zeitraum_gesamt[0]->schritte_pro_kopf
            : 0,
      ];
    }
    /*
     * Steps der besten Läufer
     */
    $steps_top = Step::select(
      "vorname",
      "name",
      "klasse",
      Step::raw("SUM(schritte) AS schritte_sum"),
      Step::raw("ROW_NUMBER() OVER (ORDER BY SUM(schritte) DESC) AS ranking")
    )
      ->withCasts(["ranking" => "integer"])
      ->groupBy("vorname", "name", "klasse")
      ->orderByDesc("schritte_sum")
      ->get();

    /*
     * Steps gruppiert nach Klassen
     */
    $klassen_sub = Step::select(
      "s.klasse",
      Step::raw("COUNT(*) AS 'teilnehmer_anzahl'")
    )
      ->fromSub(function ($query) {
        $query->from("steps")->groupBy("vorname", "name", "klasse");
      }, "s")
      ->groupBy("s.klasse");

    $steps_klassen = Step::select(
      "steps.klasse",
      Step::raw("SUM(schritte) AS schritte_sum"),
      "teilnehmer_anzahl",
      Step::raw("SUM(schritte)/teilnehmer_anzahl AS schritte_pro_kopf"),
      Step::raw(
        "ROW_NUMBER() OVER (ORDER BY SUM(schritte)/teilnehmer_anzahl DESC, teilnehmer_anzahl DESC) AS ranking"
      )
    )
      ->joinSub($klassen_sub, "steps2", "steps.klasse", "=", "steps2.klasse")
      ->withCasts(["ranking" => "integer"])
      ->groupBy("steps.klasse")
      ->having("teilnehmer_anzahl", ">", 0)
      ->orderByDesc("schritte_pro_kopf")
      ->orderByDesc("teilnehmer_anzahl")
      ->get();

    return Inertia::render("Auswertung/Index", [
      "settings.title" => $settings->get("title"),
      "steps_all" => $steps_all,
      "steps_zeitraum" => $steps_zeitraum,
      "steps_top" => $steps_top,
      "steps_klassen" => $steps_klassen,
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

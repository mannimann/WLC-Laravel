<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStepRequest;

class StepController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    /*
     * Alle Daten
     */
    $steps_all = Step::get();

    /*
     * Steps gruppiert nach Zeiträumen
     */
    $steps_zeitraum = Step::select(
      "von",
      "bis",
      Step::raw("SUM(schritte) AS schritte_sum"),
      Step::raw("COUNT(id) AS teilnehmer_count")
    )
      ->groupBy("von", "bis")
      ->orderBy("von")
      ->orderBy("bis")
      ->get();

    // Footer bzw. Zeile Gesamt
    // TODO: nur ausgeben, wenn Einträge vorhanden sind!
    $zeitraum_sub = Step::select(
      Step::raw("COUNT(*) AS 'teilnehmer_count'")
    )->fromSub(function ($query) {
      $query->from("steps")->groupBy("vorname", "name", "klasse");
    }, "s");

    $zeitraum_gesamt = Step::select(
      "von",
      "bis",
      Step::raw("SUM(schritte) AS schritte_sum"),
      Step::raw("teilnehmer_count")
    )
      ->joinSub($zeitraum_sub, "steps2", Step::raw(1), "=", Step::raw(1))
      ->get();
    $zeitraum_gesamt[0]["von"] = "";
    $zeitraum_gesamt[0]["bis"] = "";

    $steps_zeitraum = $steps_zeitraum->toBase()->merge($zeitraum_gesamt);

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

    // dd($steps_klassen);

    return Inertia::render("Steps/Index", [
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
  public function store(StoreStepRequest $request)
  {
    // $validated = $request->validate([
    //   "vorname" => "required|string|max:50",
    // ]);

    // $request->steps()->create($validated);

    // return redirect(route("steps.index"));

    /* old and working: */
    // $step = new Step();

    // $step->vorname = request("vorname");
    // $step->name = request("name");
    // $step->klasse = request("klasse");
    // $step->von = request("von");
    // $step->bis = request("bis");
    // $step->schritte = request("schritte");

    // $step->save();

    // error_log($step);

    // error_log(request("vorname"));
    // error_log(request("name"));
    // error_log(request("klasse"));
    // error_log(request("schritte"));

    /* new: */
    Step::create($request->validated());
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

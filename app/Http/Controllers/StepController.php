<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StepController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $steps_all = Step::get();

    $steps_zeitraum = Step::selectRaw(
      "von, bis, SUM(schritte) AS schritte_sum, COUNT(id) AS teilnehmer_count"
    )
      ->groupBy("von", "bis")
      ->orderBy("von")
      ->orderBy("bis")
      ->get();

    $steps_top = Step::selectRaw(
      "vorname, name, klasse, SUM(schritte) AS schritte_sum"
    )
      ->groupBy("vorname", "name", "klasse")
      ->orderByDesc("schritte_sum")
      ->get();

    // TODO: COUNT(DISTINCT vorname, name, klasse)
    $steps_klassen = Step::selectRaw(
      "klasse, SUM(schritte) AS schritte_sum, COUNT(DISTINCT vorname) AS teilnehmer_anzahl, SUM(schritte)/COUNT(DISTINCT vorname) AS schritte_pro_kopf"
    )
      ->groupBy("klasse")
      ->having("teilnehmer_anzahl", ">", 0)
      ->orderByDesc(Step::raw("schritte_pro_kopf"))
      ->orderByDesc("teilnehmer_anzahl")
      ->get();

    // dd($all, $steps);

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
  public function store(Request $request)
  {
    // $validated = $request->validate([
    //   "vorname" => "required|string|max:50",
    // ]);

    // $request->steps()->create($validated);

    // return redirect(route("steps.index"));

    $step = new Step();

    $step->vorname = request("vorname");
    $step->name = request("name");
    $step->klasse = request("klasse");
    $step->von = request("von");
    $step->bis = request("bis");
    $step->schritte = request("schritte");

    $step->save();

    error_log($step);

    // error_log(request("vorname"));
    // error_log(request("name"));
    // error_log(request("klasse"));
    // error_log(request("schritte"));
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

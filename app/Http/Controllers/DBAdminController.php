<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Inertia\Inertia;
use App\Models\Klasse;
use App\Models\Zeitraum;
use Illuminate\Http\Request;
use App\Services\StepService;
use Spatie\Valuestore\Valuestore;
use App\Http\Requests\StoreStepRequest;

class DBAdminController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // $steps = new StepService();

    $settings = Valuestore::make(
      storage_path("../database/database/settings.json")
    );

    // $steps_all = $steps->get_all();
    $klassen = Klasse::select("klasse")
      ->orderByRaw("LENGTH(klasse) ASC")
      ->orderBy("klasse")
      ->get();
    $zeiträume = Zeitraum::select("von", "bis")->get();

    return Inertia::render("DBAdmin/Index", [
      "settings.title" => $settings->get("title"),
      // "steps" => $steps_all,
      "klassen" => $klassen->values(),
      "zeiträume" => $zeiträume->values(),
    ]);
  }

  /**
   * Fetch steps dynamically.
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function fetchSteps(Request $request)
  {
    $steps = new StepService();
    $steps_all = $steps->get_all();

    return response()->json($steps_all);

    // With pagination (not quite working)

    // $perPage = $request->get("perPage", 30); // Default: 30 items per page
    // $search = $request->get("search", "");
    // $sortField = $request->get("sortField", "id");
    // $sortOrder = $request->get("sortOrder", "asc");
    // $page = $request->get("page", 1); // Default: page 1

    // // Build the query
    // $query = Step::query();

    // if ($search) {
    //   $query
    //     ->where("vorname", "like", "%{$search}%")
    //     ->orWhere("name", "like", "%{$search}%")
    //     ->orWhere("klasse", "like", "%{$search}%");
    // }

    // $steps = $query
    //   ->orderBy($sortField, $sortOrder)
    //   ->paginate($perPage, ["*"], "page", $page);

    // return response()->json($steps);
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
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(StoreStepRequest $request, $id)
  {
    $duplicate = Step::Where("vorname", $request->vorname)
      ->where("name", $request->name)
      ->where("klasse", $request->klasse)
      ->where("von", $request->von)
      ->where("bis", $request->bis)
      ->where("id", "!=", $id)
      ->count();

    if ($duplicate > 0) {
      return redirect()
        ->back()
        ->withErrors([
          "message" => "Dieser Eintrag ist bereits vorhanden!",
        ]);
    }

    $step = Step::find($id);

    $step->vorname = $request->vorname;
    $step->name = $request->name;
    $step->klasse = $request->klasse;
    $step->von = $request->von;
    $step->bis = $request->bis;
    $step->schritte = $request->schritte;
    $step->save();

    return redirect()
      ->back()
      ->with(["message" => "Daten erfolgreich geändert!"]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $step = Step::find($id);
    $step->delete();

    return redirect()
      ->back()
      ->with(["message" => "Eintrag gelöscht!"]);
  }
}

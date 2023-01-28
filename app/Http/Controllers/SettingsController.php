<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;

class SettingsController extends Controller
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

    return Inertia::render("Settings/Index", [
      "settings" => $settings->all(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    copy(
      "../database/settings_default.json",
      "../database/database/settings.json"
    );

    return redirect()
      ->back()
      ->with(["notice" => "Einstellungen zurückgesetzt"]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    error_log($request);

    $settings = Valuestore::make(
      storage_path("../database/database/settings.json")
    );

    if ($request->title != "") {
      $settings->put("title", $request->title);
    }
    if ($request->infotext != "") {
      $settings->put("infotext", $request->infotext);
    }
    if ($request->videolink != "") {
      $link = $request->videolink;
      if (str_contains($request->videolink, "watch?v=")) {
        $link = str_replace("watch?v=", "embed/", $link);
      }
      $settings->put("videolink", $link);
    }
    if ($request->email != "") {
      $settings->put("email", $request->email);
    }

    return redirect()
      ->back()
      ->with(["notice" => "Einstellungen aktualisiert"]);
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
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}

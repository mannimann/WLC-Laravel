<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;

use function PHPSTORM_META\override;

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
      ->with(["message" => "Einstellungen zurückgesetzt"]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // error_log($request);

    $settings = Valuestore::make(
      storage_path("../database/database/settings.json")
    );

    $validated = $request->validate([
      "email" => "required|email:rfc,dns",
      "title" => "required|string|max:30",
    ]);

    $settings->put("title", $validated["title"]);

    $settings->put("infotext", $request->infotext);

    $link = $request->videolink;
    if (str_contains($request->videolink, "watch?v=")) {
      $link = str_replace("watch?v=", "embed/", $link);
    }
    $settings->put("videolink", $link);

    $settings->put("email", $validated["email"]);

    $settings->put("eintragen_moeglich", $request->eintragen_moeglich);

    if ($request->override == true) {
      copy(
        "../database/database/settings.json",
        "../database/settings_default.json"
      );
    }

    return redirect()
      ->back()
      ->with(["message" => "Einstellungen aktualisiert"]);
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KlasseController extends Controller
{
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
    $request->klasse()->create($validated); //TODO

    // $klasse = new Klasse();

    // $klasse->klasse = request("klasse");
    // $klasse->klasse = $validated;

    // $klasse->save();

    // error_log($klasse);

    return redirect(route("admin.index"));
  }
}

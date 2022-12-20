<?php

namespace App\Http\Controllers;

use App\Models\Zeitraum;
use Illuminate\Http\Request;

class ZeitraumController extends Controller
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
      "von" => "required|string|max:10",
      "bis" => "required|string|max:10",
    ]);
    Zeitraum::create($validated);

    // error_log($validated["klasse"]);

    return redirect(route("admin.index"));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Zeitraum  $zeitraum
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Zeitraum $zeitraum)
  {
    $validated = $request->validate([
      "von" => "required",
      "bis" => "required",
    ]);

    $zeitraum->update($validated);

    return redirect(route("admin.index"));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Zeitraum  $zeitraum
   * @return \Illuminate\Http\Response
   */
  public function destroy(Zeitraum $zeitraum)
  {
    $zeitraum->delete();

    return redirect(route("admin.index"));
  }
}

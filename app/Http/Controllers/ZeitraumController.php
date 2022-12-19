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
}

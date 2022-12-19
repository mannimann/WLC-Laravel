<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Klasse;
use Illuminate\Http\Request;

class KlasseController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // return Inertia::render("Klasse/Index", [
    //   "klassen" => Klasse::all(),
    // ]);
  }

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
    Klasse::create($validated);

    // error_log($validated["klasse"]);

    return redirect(route("admin.index"));
  }
}

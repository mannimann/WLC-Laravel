<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Klasse;
use App\Models\Zeitraum;
use Illuminate\Http\Request;

class AdminController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $klassen = Klasse::select("*")
      ->orderBy("klasse")
      ->get();

    $zeiträume = Zeitraum::select("von", "bis")->get();

    return Inertia::render("Admin/Index", [
      "klassen" => $klassen,
      "zeiträume" => $zeiträume,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store_zeitraum(Request $request)
  {
    $zeitraum = new Zeitraum();

    $zeitraum->zeitraum = request("zeitraum");

    $zeitraum->save();

    error_log($zeitraum);
  }
}

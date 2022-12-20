<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Klasse;
use App\Models\Zeitraum;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function __invoke()
  {
    $klassen = Klasse::select("klasse")
      ->orderByRaw("LENGTH(klasse) ASC")
      ->get();
    $zeiträume = Zeitraum::select("von", "bis")->get();

    return Inertia::render("Index", [
      "klassen" => $klassen->values(),
      "zeiträume" => $zeiträume->values(),
    ]);
  }
}

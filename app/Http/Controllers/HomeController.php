<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Klasse;
use App\Models\Zeitraum;
use Spatie\Valuestore\Valuestore;

class HomeController extends Controller
{
  public function __invoke()
  {
    $settings = Valuestore::make(
      storage_path("../database/database/settings.json")
    );

    $klassen = Klasse::select("klasse")
      ->orderByRaw("LENGTH(klasse) ASC")
      ->get();
    $zeiträume = Zeitraum::select("von", "bis")->get();

    return Inertia::render("Index", [
      "settings" => $settings->all(),
      "klassen" => $klassen->values(),
      "zeiträume" => $zeiträume->values(),
    ]);
  }
}

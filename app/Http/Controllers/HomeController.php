<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Spatie\Valuestore\Valuestore;

class HomeController extends Controller
{
  public function __invoke()
  {
    $settings = Valuestore::make(
      storage_path("../database/database/settings.json")
    );

    return Inertia::render("Index", [
      "settings.title" => $settings->get("title"),
    ]);
  }
}

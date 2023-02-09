<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EintragenController;
use App\Http\Controllers\AuswertungController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KlasseController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ZeitraumController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get("/welcome", function () {
//   return Inertia::render("Welcome", [
//     "canLogin" => Route::has("login"),
//     "canRegister" => Route::has("register"),
//     "laravelVersion" => Application::VERSION,
//     "phpVersion" => PHP_VERSION,
//   ]);
// });

Route::resource("/dashboard", DashboardController::class, [
  "names" => "dashboard",
])
  ->middleware(["auth", "verified"])
  ->only(["index"]);

// Route::resource("/", StepController::class)
//   //   ->name("steps")
//   ->only(["index", "store"]);

// Route::get("/auswertung", function () {
//   return Inertia::render("Auswertung/Index");
// })->name("auswertung");

// Route::get("/steps", function () {
//   return Inertia::render("Steps/Index");
// })->name("steps");

// Route::get("/", function () {
//   return Inertia::render("Dashboard");
// })->name("home");

Route::get("/", HomeController::class)->name("home");

Route::resource("/eintragen", EintragenController::class, [
  "names" => "eintragen",
])->only(["index", "store"]);

Route::resource("/auswertung", AuswertungController::class, [
  "names" => "auswertung",
])->only(["index"]);

Route::resource("/kontakt", ContactController::class, [
  "names" => "kontakt",
])->only(["index", "store"]);

Route::prefix("admin")
  ->middleware("auth", "verified")
  ->name("admin.")
  ->group(function () {
    Route::resource("/", AdminController::class, [
      "names" => "home",
    ])->only("index", "destroy");
    // Route::get("/admin", [AdminController::class, "index"])->name("admin");

    Route::resource("/einstellungen", SettingsController::class, [
      "names" => "einstellungen",
    ])->only(["index", "store", "create"]);

    Route::resource("/nachrichten", MessageController::class, [
      "names" => "nachrichten",
    ])->only(["index", "update", "destroy"]);
  });

Route::apiResources([
  "klasse" => KlasseController::class,
  "zeitraum" => ZeitraumController::class,
]);

require __DIR__ . "/auth.php";

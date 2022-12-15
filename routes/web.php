<?php

use App\Http\Controllers\HomeController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\StepController;

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

Route::get("/welcome", function () {
  return Inertia::render("Welcome", [
    "canLogin" => Route::has("login"),
    "canRegister" => Route::has("register"),
    "laravelVersion" => Application::VERSION,
    "phpVersion" => PHP_VERSION,
  ]);
});

Route::get("/dashboard", function () {
  return Inertia::render("Dashboard");
})
  ->middleware(["auth", "verified"])
  ->name("dashboard");

// Route::resource("/", StepController::class)
//   //   ->name("steps")
//   ->only(["index", "store"]);

// Route::get("/auswertung", function () {
//   return Inertia::render("Auswertung/Index");
// })->name("auswertung");

// Route::get("/steps", function () {
//   return Inertia::render("Steps/Index");
// })->name("steps");

// TODO: DB-Inhalt in Auswertung anzeigen
// TODO: Routes umbauen -> Steps/Index wird nicht angezeigt, sondern nur "/"

Route::get("/", HomeController::class)->name("home");
// Route::get("/", function () {
//   return Inertia::render("Dashboard");
// })->name("home");

Route::resource("/auswertung", StepController::class, [
  "names" => "steps",
])->only(["index", "store"]);

require __DIR__ . "/auth.php";

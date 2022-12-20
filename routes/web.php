<?php

use App\Http\Controllers\HomeController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\StepController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KlasseController;
use App\Http\Controllers\ZeitraumController;

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

// Route::get("/", function () {
//   return Inertia::render("Dashboard");
// })->name("home");

Route::get("/", HomeController::class)->name("home");

Route::resource("/auswertung", StepController::class, [
  "names" => "steps",
])->only(["index", "store"]);

// Route::prefix('admin')->middleware('auth')->group(function() {
//   //
// });

Route::resource("/admin", AdminController::class, [
  "names" => "admin",
])->only("index");
// Route::get("/admin", [AdminController::class, "index"])->name("admin");

Route::apiResources([
  "klasse" => KlasseController::class,
  "zeitraum" => ZeitraumController::class,
]);

require __DIR__ . "/auth.php";

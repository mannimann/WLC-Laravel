<?php

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

Route::resource("/", StepController::class)
  //   ->name("steps")
  ->only(["index", "store"]);

Route::inertia("/auswertung", "Auswertung/Index")->name("auswertung");
Route::inertia("/steps", "Steps/Index")->name("steps");

require __DIR__ . "/auth.php";

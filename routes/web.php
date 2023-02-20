<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\KlasseController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DBAdminController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ZeitraumController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EintragenController;
use App\Http\Controllers\AuswertungController;

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

Route::resource("/dashboard", DashboardController::class, [
  "names" => "dashboard",
])
  ->middleware(["auth"])
  ->only(["index"]);

Route::prefix("admin")
  ->middleware("auth")
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

    Route::resource("/dbadmin", DBAdminController::class, [
      "names" => "dbadmin",
    ])->only(["index", "update", "destroy"]);

    Route::resource("/users", UserController::class, [
      "names" => "users",
    ])->only(["index", "create", "update", "destroy"]);

    Route::get("/export", [ExcelController::class, "export"])->name("export");
  });

Route::apiResources([
  "klasse" => KlasseController::class,
  "zeitraum" => ZeitraumController::class,
]);

require __DIR__ . "/auth.php";

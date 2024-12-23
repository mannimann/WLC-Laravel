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
    ])->only("index");
    Route::resource("/", AdminController::class, [
      "names" => "home",
    ])
      ->middleware(["adminReadOnly"])
      ->only("destroy");

    Route::resource("/einstellungen", SettingsController::class, [
      "names" => "einstellungen",
    ])->only(["index"]);
    Route::resource("/einstellungen", SettingsController::class, [
      "names" => "einstellungen",
    ])
      ->middleware(["adminReadOnly"])
      ->only(["store", "create"]);

    Route::resource("/nachrichten", MessageController::class, [
      "names" => "nachrichten",
    ])->only(["index"]);
    Route::resource("/nachrichten", MessageController::class, [
      "names" => "nachrichten",
    ])
      ->middleware(["adminReadOnly"])
      ->only(["update", "destroy"]);

    Route::resource("/dbadmin", DBAdminController::class, [
      "names" => "dbadmin",
    ])->only(["index"]);
    Route::get("/dbadmin/steps", [
      DBAdminController::class,
      "fetchSteps",
    ])->name("dbadmin.steps");
    Route::resource("/dbadmin", DBAdminController::class, [
      "names" => "dbadmin",
    ])
      ->middleware(["adminReadOnly"])
      ->only(["update", "destroy"]);

    Route::resource("/users", UserController::class, [
      "names" => "users",
    ])->only(["index", "create", "update", "destroy"]);

    Route::get("/export", [ExcelController::class, "export"])->name("export");
  });

Route::group(["middleware" => "adminReadOnly"], function () {
  Route::apiResources([
    "klasse" => KlasseController::class,
    "zeitraum" => ZeitraumController::class,
  ]);
});

// Route::get("artisan", function () {
//   // Call and Artisan command from within your application.
//   Artisan::call("cache:clear");
// });

require __DIR__ . "/auth.php";

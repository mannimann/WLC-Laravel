<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(): Response
  {
    $settings = Valuestore::make(
      storage_path("../database/database/settings.json")
    );

    if (auth()->user()->permission_level < 2) {
      return Inertia::render("AccessDenied", [
        "settings.title" => $settings->get("title"),
        "admin_layout" => true,
      ]);
    }

    $users = User::select(
      "id",
      "name",
      "email",
      "created_at",
      "permission_level",
      "active"
    )
      ->orderBy("permission_level", "desc")
      ->get();

    return Inertia::render("Users/Index", [
      "settings.title" => $settings->get("title"),
      "users" => $users->values(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return URL::temporarySignedRoute("register", now()->addDays(7), []);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id): RedirectResponse
  {
    // Set Active-State
    if ($request->type == "active") {
      if (auth()->user()->id == (int) $id) {
        return redirect()
          ->back()
          ->withErrors([
            "message" => "Eigener Account kann nicht deaktiviert werden!",
          ]);
      }

      $user = User::select("id", "permission_level")
        ->where("id", $id)
        ->get();
      if (auth()->user()->permission_level <= $user[0]->permission_level) {
        return redirect()
          ->back()
          ->withErrors([
            "message" => "Keine Berechtigung!",
          ]);
      }

      User::where("id", $id)->update(["active" => $request->active]);

      return redirect()
        ->back()
        ->with(["message" => "Status geändert!"]);
    }

    // Set Permission Level
    if ($request->type == "permission") {
      if ($request->permission_level < 0 || $request->permission_level > 3) {
        return redirect()
          ->back()
          ->withErrors([
            "message" => "Fehler: Kein gültiger Wert!",
          ]);
      }

      if (auth()->user()->id == (int) $id) {
        return redirect()
          ->back()
          ->withErrors([
            "message" => "Eigene Berechtigung kann nicht verändert werden!",
          ]);
      }

      $user = User::select("id", "permission_level")
        ->where("id", $id)
        ->get();
      if (
        auth()->user()->permission_level <= $user[0]->permission_level ||
        $request->permission_level > auth()->user()->permission_level
      ) {
        return redirect()
          ->back()
          ->withErrors([
            "message" => "Keine Berechtigung!",
          ]);
      }

      User::where("id", $id)->update([
        "permission_level" => $request->permission_level,
      ]);

      return redirect()
        ->back()
        ->with(["message" => "Zugriff geändert!"]);
    }

    // return ist no valid option
    return redirect()
      ->back()
      ->withErrors(["message" => "Funktion nicht gefunden"]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id): RedirectResponse
  {
    if (auth()->user()->id == (int) $id) {
      return redirect()
        ->back()
        ->withErrors([
          "message" => "eigener Account kann nicht gelöscht werden!",
        ]);
    }

    $user = User::select("id", "permission_level")
      ->where("id", $id)
      ->get();
    if (auth()->user()->permission_level <= $user[0]->permission_level) {
      return redirect()
        ->back()
        ->withErrors([
          "message" => "keine Berechtigung!",
        ]);
    }

    User::where("id", $id)->delete();

    return redirect()
      ->back()
      ->with(["message" => "Nutzer gelöscht!"]);
  }
}

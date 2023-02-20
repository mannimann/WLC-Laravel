<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Spatie\Valuestore\Valuestore;

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

  // /**
  //  * Show the form for creating a new resource.
  //  */
  // public function create(): Response
  // {
  //     //
  // }

  // /**
  //  * Store a newly created resource in storage.
  //  */
  // public function store(Request $request): RedirectResponse
  // {
  //     //
  // }

  // /**
  //  * Display the specified resource.
  //  */
  // public function show(string $id): Response
  // {
  //     //
  // }

  // /**
  //  * Show the form for editing the specified resource.
  //  */
  // public function edit(string $id): Response
  // {
  //     //
  // }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id): RedirectResponse
  {
    if (auth()->user()->id == (int) $id) {
      return redirect()
        ->back()
        ->withErrors([
          "message" => "eigener Account kann nicht deaktiviert werden!",
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

    User::where("id", $id)->update(["active" => $request->active]);

    return redirect()
      ->back()
      ->with(["message" => "Status geändert!"]);
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
    error_log("Nutzer {$id} gelöscht");

    return redirect()
      ->back()
      ->with(["message" => "Nutzer gelöscht!"]);
  }
}

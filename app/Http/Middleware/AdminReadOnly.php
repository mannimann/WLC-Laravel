<?php

namespace App\Http\Middleware;

use Closure;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;

class AdminReadOnly
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next)
  {
    $settings = Valuestore::make(
      storage_path("../database/database/settings.json")
    );

    if (auth()->user()->permission_level < 1) {
      // return Inertia::render("AccessDenied", [
      //   "settings.title" => $settings->get("title"),
      //   "admin_layout" => true,
      // ]);
      return redirect()
        ->back()
        ->withErrors(["message" => "Keine Berechtigung!"]);
    }

    return $next($request);
  }
}

<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;

class BlockRegister
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next)
  {
    if (!$request->hasValidSignature()) {
      $users = User::count();
      if ($users >= 2) {
        $settings = Valuestore::make(
          storage_path("../database/database/settings.json")
        );

        return Inertia::render("Auth/RegisterDenied", [
          "settings.title" => $settings->get("title"),
          "admin_layout" => false,
        ]);
      }
    }

    return $next($request);
  }
}

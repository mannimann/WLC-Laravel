<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckActive
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (auth()->check() && auth()->user()->active == 0) {
      Auth::logout();

      $request->session()->invalidate();

      $request->session()->regenerateToken();

      return redirect()
        ->route("login")
        ->withErrors([
          "message" =>
            "Dein Account wurde deaktiviert, bitte kontaktiere den Administrator.",
        ]);
    }

    return $next($request);
  }
}

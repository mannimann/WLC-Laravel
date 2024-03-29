<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
  /**
   * Display the registration view.
   *
   * @return \Inertia\Response
   */
  public function create(Request $request)
  {
    if ($request->hasValidSignature()) {
      return Inertia::render("Auth/Register", [
        "expires" => $request->expires,
        "signature" => $request->signature,
      ]);
    } else {
      return Inertia::render("Auth/Register", [
        "expires" => "",
        "signature" => "",
      ]);
    }
  }

  /**
   * Handle an incoming registration request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request)
  {
    $request->validate([
      "name" => "required|string|max:255",
      "email" => "required|string|email:rfc,dns|max:255|unique:users",
      "password" => ["required", "confirmed", Rules\Password::defaults()],
    ]);

    $user_count = User::count();

    $user = User::create([
      "name" => $request->name,
      "email" => $request->email,
      "password" => Hash::make($request->password),
      "permission_level" => $user_count < 2 ? 2 : 0,
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect(RouteServiceProvider::HOME);
  }
}

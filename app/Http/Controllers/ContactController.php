<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Message;
use Error;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $settings = Valuestore::make(
      storage_path("../database/database/settings.json")
    );

    return Inertia::render("Contact/Index", [
      "settings.title" => $settings->get("title"),
      "settings.email" => $settings->get("email"),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $settings = Valuestore::make(
      storage_path("../database/database/settings.json")
    );

    $validated = $request->validate([
      "name" => "required|string|max:50",
      "klasse" => "required|string|max:15",
      "email" => "required|email:rfc,dns|max:50",
      "nachricht" => "required|string|max:500",
    ]);

    Message::create($validated);

    //Send Email
    $message =
      "Name: " .
      $validated["name"] .
      "\n" .
      "Klasse: " .
      $validated["klasse"] .
      "\n\n" .
      $validated["nachricht"];

    Mail::raw($message, function ($mail) use ($settings, $validated) {
      $mail->to($settings->get("email"));
      $mail->from($validated["email"]);
      $mail->subject($settings->get("title") . " - Kontaktformular");
    });

    return redirect()
      ->back()
      ->with(["message" => "Nachricht geschickt"]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}

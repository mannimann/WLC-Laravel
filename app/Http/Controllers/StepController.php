<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StepController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Inertia::render("Steps/Index", []);
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
    $validated = $request->validate([
      "vorname" => "required|string|max:50",
    ]);

    $request->steps()->create($validated);

    return redirect(route("steps.index"));
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Step  $step
   * @return \Illuminate\Http\Response
   */
  public function show(Step $step)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Step  $step
   * @return \Illuminate\Http\Response
   */
  public function edit(Step $step)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Step  $step
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Step $step)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Step  $step
   * @return \Illuminate\Http\Response
   */
  public function destroy(Step $step)
  {
    //
  }
}

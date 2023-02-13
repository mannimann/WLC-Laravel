<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStepRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    // $screenshot = base64_encode("screenshot");
    return [
      "vorname" => "required|string|min:3|max:35",
      "name" => "required|string|min:3|max:35",
      "klasse" => "required|string|max:10", // in_array:
      "von" => "required|date",
      "bis" => "required|date",
      "schritte" => "required|integer|gt:0",
      "screenshot" => "",
      // $screenshot => "nullable|file|mimes:jpeg,jpg,png",
    ];
  }

  public function messages()
  {
    return [
      "von.required" => "Zeitraum muss ausgefüllt werden.",
      "bis.required" => "Zeitraum muss ausgefüllt werden.",
      "von.date" => "Zeitraum muss ein gültiges Datum sein.",
      "bis.date" => "Zeitraum muss ein gültiges Datum sein.",
    ];
  }
}

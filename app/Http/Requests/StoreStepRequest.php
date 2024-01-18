<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Validation\Rule;

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
    // validate only true (for terms)
    Validator::extend("true", function (
      $attribute,
      $value,
      $parameters,
      $validator
    ) {
      if ($value == true) {
        return true;
      }

      return false;
    });

    // validate base64-image
    Validator::extend("base64image", function (
      $attribute,
      $value,
      $parameters,
      $validator
    ) {
      $explode = explode(",", $value);
      $allow = ["png", "jpg", "jpeg"];
      $format = str_replace(
        ["data:image/", ";", "base64"],
        ["", "", ""],
        $explode[0]
      );

      // check file format
      if (!in_array($format, $allow)) {
        return false;
      }

      // check base64 format
      if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
        return false;
      }

      return true;
    });

    // validate max-size
    Validator::extend("base64imageMax", function (
      $attribute,
      $value,
      $parameters,
      $validator
    ) {
      if (empty($value)) {
        return true;
      }

      function convertToFile(string $value): File
      {
        if (strpos($value, ";base64") !== false) {
          [, $value] = explode(";", $value);
          [, $value] = explode(",", $value);
        }

        $binaryData = base64_decode($value);
        $tmpFile = tmpfile();
        $tmpFilePath = stream_get_meta_data($tmpFile)["uri"];

        file_put_contents($tmpFilePath, $binaryData);

        return new File($tmpFilePath);
      }

      return $validator->validateMax(
        $attribute,
        convertToFile($value),
        $parameters
      );
    });

    // dynamic error message
    Validator::replacer("base64imageMax", function (
      $message,
      $attribute,
      $rule,
      $parameters
    ) {
      return str_replace(":max", $parameters[0], $message);
    });

    // main validation
    return [
      "vorname" => "required|string|min:3|max:35",
      "name" => "required|string|min:3|max:35",
      "klasse" => "required|string|max:10", // evtl.: in_array:...
      "von" => "required|date",
      "bis" => "required|date",
      "schritte" => "required|integer|gt:0",
      "screenshot" => "nullable|base64image|base64imageMax:500",
      "terms" => "required|boolean|true",
    ];
  }

  public function messages()
  {
    return [
      "von.required" => "Zeitraum muss ausgefüllt werden.",
      "bis.required" => "Zeitraum muss ausgefüllt werden.",
      "von.date" => "Zeitraum muss ein gültiges Datum sein.",
      "bis.date" => "Zeitraum muss ein gültiges Datum sein.",
      "screenshot.base64image" =>
        "Screenshot muss ein Bild im JPG oder PNG Format sein.",
      "screenshot.base64image_max" =>
        "Das Bild darf maximal :max kB groß sein.",
      "terms" => "Zustimmung erforderlich.",
    ];
  }
}

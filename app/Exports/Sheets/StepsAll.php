<?php

namespace App\Exports\Sheets;

use App\Models\Step;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StepsAll implements FromCollection, WithTitle, WithHeadings
{
  public function headings(): array
  {
    return ["Vorname", "Name", "Klasse", "Kategorie", "Von", "Bis", "Schritte"];
  }

  /**
   * @return Builder
   */
  public function collection()
  {
    $steps = Step::select(
      "vorname",
      "name",
      "steps.klasse",
      "kategorie",
      "von",
      "bis",
      "schritte"
    )
      ->join("klassen", "steps.klasse", "=", "klassen.klasse")
      ->withCasts(["von" => "date:d.m.Y"])
      ->withCasts(["bis" => "date:d.m.Y"])
      ->get();

    return $steps;
  }

  /**
   * @return string
   */
  public function title(): string
  {
    return "Alle Einträge";
  }
}

<?php

namespace App\Exports\Sheets;

use App\Models\Zeitraum;
use App\Services\StepService;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StepsLäuferGruppiert implements FromCollection, WithTitle, WithHeadings
{
  public function headings(): array
  {
    $headings = ["#", "Vorname", "Nachname", "Klasse", "Schritte Gesamt"];

    $zeiträume = Zeitraum::select("von", "bis")
      ->orderBy("von")
      ->orderBy("bis")
      ->get();

    foreach ($zeiträume as $zeitraum) {
      $headings[] =
        date_format(date_create($zeitraum->von), "d.m.") .
        " - " .
        date_format(date_create($zeitraum->bis), "d.m.y");
    }

    return $headings;
  }

  /**
   * @return Builder
   */
  public function collection()
  {
    $service = new StepService();
    $steps = $service->get_steps_läufer_zeitraum();
    return collect($steps);
  }

  /**
   * @return string
   */
  public function title(): string
  {
    return "Personen mit Zeitraum";
  }
}

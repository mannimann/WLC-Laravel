<?php

namespace App\Exports\Sheets;

use App\Services\StepService;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StepsKlassen implements FromCollection, WithTitle, WithHeadings
{
  public function headings(): array
  {
    return [
      "#",
      "Klasse",
      "Schritte pro Kopf",
      "Schritte Gesamt",
      "Anzahl Teilnehmer",
    ];
  }

  /**
   * @return Builder
   */
  public function collection()
  {
    $service = new StepService();
    $steps = $service->get_steps_klassen();
    return collect($steps);
  }

  /**
   * @return string
   */
  public function title(): string
  {
    return "Klassen";
  }
}

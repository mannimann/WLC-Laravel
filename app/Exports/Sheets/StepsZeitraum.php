<?php

namespace App\Exports\Sheets;

use App\Services\StepService;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StepsZeitraum implements FromCollection, WithTitle, WithHeadings
{
  public function headings(): array
  {
    return [
      "Zeitraum",
      "Schritte Gesamt",
      "Anzahl Teilnehmer",
      "Schritte pro Kopf",
    ];
  }

  /**
   * @return Builder
   */
  public function collection()
  {
    $service = new StepService();
    $steps = $service->get_steps_zeitraum();
    return collect($steps);
  }

  /**
   * @return string
   */
  public function title(): string
  {
    return "Zeiträume";
  }
}

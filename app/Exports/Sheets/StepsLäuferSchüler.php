<?php

namespace App\Exports\Sheets;

use App\Services\StepService;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StepsLäuferSchüler implements FromCollection, WithTitle, WithHeadings
{
  public function headings(): array
  {
    return ["#", "Vorname", "Nachname", "Klasse", "Schritte Gesamt"];
  }

  /**
   * @return Builder
   */
  public function collection()
  {
    $service = new StepService();
    $steps = $service->get_steps_läufer_schüler();
    return collect($steps);
  }

  /**
   * @return string
   */
  public function title(): string
  {
    return "Schüler";
  }
}

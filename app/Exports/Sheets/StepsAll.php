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
    return ["Id", "Vorname", "Name", "Klasse", "Von", "Bis", "Schritte"];
  }

  /**
   * @return Builder
   */
  public function collection()
  {
    return Step::select(
      "id",
      "vorname",
      "name",
      "klasse",
      "von",
      "bis",
      "schritte"
    )->get();
  }

  /**
   * @return string
   */
  public function title(): string
  {
    return "Alle Einträge";
  }
}

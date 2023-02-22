<?php

namespace App\Exports\Sheets;

use App\Models\Step;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StepsDB implements FromCollection, WithTitle, WithHeadings
{
  public function headings(): array
  {
    return [
      "id",
      "vorname",
      "name",
      "klasse",
      "von",
      "bis",
      "schritte",
      "created_at",
      "updated_at",
    ];
  }

  /**
   * @return Builder
   */
  public function collection()
  {
    $steps = Step::select(
      "id",
      "vorname",
      "name",
      "klasse",
      "von",
      "bis",
      "schritte",
      "created_at",
      "updated_at"
    )->get();

    return $steps;
  }

  /**
   * @return string
   */
  public function title(): string
  {
    return "Datenbankinhalt";
  }
}

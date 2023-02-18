<?php

namespace App\Exports;

use App\Exports\Sheets\StepsAll;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StepExport implements WithMultipleSheets
{
  use Exportable;

  public function sheets(): array
  {
    $sheets = [];

    $sheets[] = new StepsAll();

    return $sheets;
  }
}

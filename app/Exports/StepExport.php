<?php

namespace App\Exports;

use App\Exports\Sheets\StepsAll;
use App\Exports\Sheets\StepsLäufer;
use App\Exports\Sheets\StepsKlassen;
use App\Exports\Sheets\StepsLäuferGruppiert;
use App\Exports\Sheets\StepsZeitraum;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StepExport implements WithMultipleSheets
{
  use Exportable;

  public function sheets(): array
  {
    $sheets = [];

    $sheets[] = new StepsAll();
    $sheets[] = new StepsZeitraum();
    $sheets[] = new StepsLäufer();
    $sheets[] = new StepsKlassen();
    $sheets[] = new StepsLäuferGruppiert();

    return $sheets;
  }
}

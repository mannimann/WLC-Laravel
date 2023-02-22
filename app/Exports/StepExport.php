<?php

namespace App\Exports;

use App\Exports\Sheets\StepsAll;
use App\Exports\Sheets\StepsKlassen;
use App\Exports\Sheets\StepsLäuferSchüler;
use App\Exports\Sheets\StepsLäuferErwachsene;
use App\Exports\Sheets\StepsLäuferGruppiert;
use App\Exports\Sheets\StepsDB;
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
    $sheets[] = new StepsKlassen();
    $sheets[] = new StepsLäuferSchüler();
    $sheets[] = new StepsLäuferErwachsene();
    $sheets[] = new StepsLäuferGruppiert();
    $sheets[] = new StepsDB();

    return $sheets;
  }
}

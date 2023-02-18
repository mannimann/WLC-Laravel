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

  //   protected $sheets;

  //   /**
  //    * @return array
  //    */
  //   public function sheets(): array
  //   {
  //     $sheets = [];

  //     // for ($month = 1; $month <= 12; $month++) {
  //     //   $sheets[] = new Step($this->year, $month);
  //     // }
  //     $sheets[0] = Step::all();
  //     return $sheets;
  //     // return Step::all();
  //   }

  //   /**
  //    * @return string
  //    */
  //   public function title(): string
  //   {
  //     return "Month ";
  //   }

  //   /**
  //    * @return \Illuminate\Support\Collection
  //    */
  //   public function collection()
  //   {
  //     $file = StepExport::sheets();
  //     return $file;
  //   }
}

<?php

namespace App\Http\Controllers;

use App\Exports\StepExport;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
  /**
   * Export all Data.
   *
   * @return \Illuminate\Http\Response
   */
  public function export()
  {
    $settings = Valuestore::make(
      storage_path("../database/database/settings.json")
    );

    return Excel::download(new StepExport(), $settings->get("title") . ".xlsx");
  }
}

<?php

namespace App\Http\Controllers\DriverModuleControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateReportController extends Controller
{
  public function index()
  {
    return view('drivermodule.report.driverReport');
  }
}

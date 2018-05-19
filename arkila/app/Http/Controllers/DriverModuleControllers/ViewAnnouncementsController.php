<?php

namespace App\Http\Controllers\DriverModuleControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Announcement;
class ViewAnnouncementsController extends Controller
{
    public function showAnnouncement()
    {
      return view('drivermodule.indexAnnouncements', compact('announcements'));
    }
}

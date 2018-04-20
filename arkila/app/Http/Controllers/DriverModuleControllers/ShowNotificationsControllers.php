<?php

namespace App\Http\Controllers\DriverModuleControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowNotificationsControllers extends Controller
{
    public function index()
    {
      return view('drivermodule.notifications');
    }

    public function notifications()
    {
      return auth()->user()->unreadNotifications()->limit(5)->get()->toArray();
    }

    public function markAsRead()
    {
      return auth()->user()->unreadNotifications->markAsRead();
    }
}

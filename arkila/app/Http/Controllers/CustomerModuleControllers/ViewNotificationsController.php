<?php

namespace App\Http\Controllers\CustomerModuleControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewNotificationsController extends Controller
{
  public function notifications()
  {
      return auth()->user()->unreadNotifications()->limit(5)->get()->toArray();
  }

  public function markAsRead()
  {
    return auth()->user()->unreadNotifications()->markAsRead();
  }
}

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
      return auth()->user()->unreadNotifications()->get()->toArray();
    }

    public function markAsRead()
    {
      return auth()->user()->unreadNotifications->markAsRead();
    }

    public function markAsReadSpecific($id)
    {
        $notification = auth()->user()
        ->unreadNotifications()
        ->where('id', $id)
        ->first();

        if (is_null($notification)) {
        return response()->json('Notification not found.', 404);
        }

        $notification->markAsRead();
    }
}

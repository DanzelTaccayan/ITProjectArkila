<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class MarkAsReadNotificationController extends Controller
{
    public function markAsRead()
    {
      $user = User::find(Auth::id());  
      return $user->unreadNotifications->markAsRead();
    }
}

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

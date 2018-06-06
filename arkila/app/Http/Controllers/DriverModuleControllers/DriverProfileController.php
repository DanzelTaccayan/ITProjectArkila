<?php

namespace App\Http\Controllers\DriverModuleControllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Member;
use App\Trip;
use DB;
use Response;


class DriverProfileController extends Controller
{
      public function showDriverProfile()
      {
        $driverId = Auth::id();
        $profile = Member::where('user_id', $driverId)->first();
        $driverTrips = Trip::all();
        $counter = 0;
        foreach($driverTrips as $driverTrip){
          if($driverTrip->driver_id === Auth::id()){
              $counter++;
          }
        }


        return view('drivermodule.profile.driverProfile', compact('profile', 'counter', 'driverId'));

      }

      public function changeNotificationStatus()
      {
          // Start transaction!
          DB::beginTransaction();
          try  {

              $id = request('id');

              $user = Member::findOrFail($id);
              if($user->notification === "Enable"){
                  $user->notification = "Disable";
                  $message = ["success" => "You have successfully disabled your notifications"];
              }elseif($user->notification === "Disable"){
                  $user->notification = "Enable";
                  $message = ["success" => "You have successfully enabled your notifications"];
              }

              $user->save();

              DB::commit();
              return response()->json($message);
          } catch(\Exception $e) {
              DB::rollback();
              \Log::info($e);
              return Response::json(['error'=>'Oops! Something went wrong on the server. If the problem persists contact the administrator'],422);
          }

      }

      public function checkCurrentPassword()
      {
        if(Auth::id() == request('id')){

          $checkCurrentPassword = Hash::check(request('current_password'), Auth::user()->password);
          if($checkCurrentPassword){
            return response()->json([
              'success' => $checkCurrentPassword
            ]);
          }else{
            return response()->json([
              'success' => $checkCurrentPassword
            ]);
          }
        }
        return response()->json([
          'message' => 'You do not have access to that account! '
        ]);
      }

      public function updatePassword(User $driverId)
      {
        $checkCurrentPassword = Hash::check(request('current_password'), Auth::user()->password);
        if(!$checkCurrentPassword){
            return redirect('/home/profile')->with('error', 'Password does not match');
        }
        $this->validate(request(), [
            "password" => "required|confirmed",
        ]);

          // Start transaction!
          DB::beginTransaction();
          try  {
              Auth::user()->password = Hash::make(request('password'));
              Auth::user()->save();
              Auth::logout();


              DB::commit();
              return redirect('/login')->with('success', 'Successfully changed password');
          } catch(\Exception $e) {
              DB::rollback();
              \Log::info($e);

              return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
          }
      }
}

<?php

namespace App\Http\Controllers\CustomerModuleControllers;

use App\Rental;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ViewTransactionsController extends Controller
{
    public function viewTransactions()
    {
    	$rentals = Rental::orderBy('rental.created_at', 'desc')->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
    	$reservations = Reservation::orderBy('reservation.created_at', 'desc')->where('user_id', Auth::id())->get();

    	return view('customermodule.user.transactions.customerTransactions', compact('rentals', 'reservations'));
    }

    public function cancelRental(Rental $rental)
    {
    	$rental->update([
        'status' => 'Cancelled',
      ]);
    	return back()->with('success','Your rental has been cancelled successfully');
    }

    public function destroyRental(Rental $rental)
    {
      $rental->update([
        'status' => 'Cancelled',
      ]);
    	return back()->with('success','Rental has been deleted successfully');
    }

    public function destroyReservation(Reservation $reservation)
    {
    	$reservation->delete();
    	return back()->with('success', 'Reservation has been deleted successfully');
    }
}

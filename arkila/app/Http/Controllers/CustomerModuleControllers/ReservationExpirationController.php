<?php

namespace App\Http\Controllers\CustomerModuleControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationExpirationController extends Controller
{
    public function test()
    {
        if($reservation->reservationDate->reservation_date->subDays(2)->gt($reservation->expiry_date) && $reservation->status == 'EXPIRED' && $reservation->returned_slot == false)
        {
            $quantity = $reservation->ticket_quantity;
            $orig = $reservation->reservationDate->number_of_slots;
            $updatedSlots = $quantity + $orig;

            $reservation->reservationDate->update([
                'number_of_slots' => $updatedSlots,
            ]);
            $reservation->update([
                'returned_slot' => true,
            ]);
            
        }
    }
}

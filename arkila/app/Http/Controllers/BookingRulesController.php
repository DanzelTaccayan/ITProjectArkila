<?php

namespace App\Http\Controllers;

use App\BookingRules;
use Illuminate\Http\Request;

class BookingRulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservationRule = BookingRules::where('description', 'Reservation')->get()->first();
        $rentalRule = BookingRules::where('description', 'Rental')->get()->first();
        return view('bookingrules.index', compact('reservationRule', 'rentalRule'));
    }

    public function storeOrUpdateReservation(Request $request)
    {
        $this->validate($request, [
            'reservationFee' => 'required|numeric|min:0',
            'reservationCancellation' => 'required|numeric|min:0',
            'reservationPayment' => 'required|numeric|min:0',
            'reservationRefund' => 'required|numeric|min:0',
        ]);
        $reservationRule = BookingRules::where('description', 'Reservation')->get()->first();
        if(!$reservationRule) {
            BookingRules::create([
                'description' => 'Reservation',
                'fee' => $request->reservationFee,
                'cancellation_fee' => $request->reservationCancellation,
                'payment_due' => $request->reservationPayment,
                'refund_expiry' => $request->reservationRefund,
            ]);
        } else {
            $reservationRule->update([
                'fee' => $request->reservationFee,
                'cancellation_fee' => $request->reservationCancellation,
                'payment_due' => $request->reservationPayment,
                'refund_expiry' => $request->reservationRefund,
            ]);
        }
        return back()->with('success', 'Reservation rules has been updated successfully');
    }

    public function storeOrUpdateRental(Request $request)
    {
        $this->validate($request, [
            'rentalFee' => 'required|numeric|min:0',
            'rentalCancellation' => 'required|numeric|min:0',
            'rentalPayment' => 'required|numeric|min:0',
            'rentalRequest' => 'required|numeric|min:0',
            'rentalRefund' => 'required|numeric|min:0',
        ]);
        $rentalRule = BookingRules::where('description', 'Rental')->get()->first();

        if(!$rentalRule) {
            BookingRules::create([
                'description' => 'Rental',
                'fee' => $request->rentalFee,
                'cancellation_fee' => $request->rentalCancellation,
                'payment_due' => $request->rentalPayment,
                'refund_expiry' => $request->rentalRefund,
                'request_expiry' => $request->rentalRequest,
            ]);       
        } else {
            $rentalRule->update([
                'fee' => $request->rentalFee,
                'cancellation_fee' => $request->rentalCancellation,
                'payment_due' => $request->rentalPayment,
                'refund_expiry' => $request->rentalRefund,
                'request_expiry' => $request->rentalRequest,                
            ]);
        }
        return back()->with('success', 'Rental rules has been updated successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Trip;
use App\Ticket;
use App\VanQueue;
use App\Transaction;
use App\Destination;
use Illuminate\Http\Request;

class ViewLiveVanQueueController extends Controller
{
    public function index()
    {
        $terminals = Destination::where('is_terminal', true)->where('is_main_terminal', false)->with('vanQueue')->get();
        // foreach($terminals as $t){
        //     echo $t->vanQueue;
        // }
        return view('ticketmanagement.queue', compact('terminals'));
    }

    public function getVanQueue()
    {
        $vanqueue = VanQueue::where('queue_number', '1')->with(['van','destination','driver'])->get();

        $tickets = Transaction::where('status', 'Pending')->where('trip_id', null)->get();



        return response()->json(['vanqueue' => $vanqueue, 'tickets' => $tickets]);
    }


}

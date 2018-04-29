<?php

namespace App\Http\Controllers;

use App\VanQueue;
use App\Destination;
use App\Member;
use App\Van;
use Illuminate\Http\Request;

class VanQueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terminals = Destination::where('is_main_terminal',0);
        $queues = VanQueue::whereNotNull('queue_number')->orderBy('queue_number')->get();

        $drivers = Member::whereNotIn('member_id', function($query){
            $query->select('driver_id')->from('van_queue');
        })->where('status','Active')->get();

        $vans = Van::whereNotIn('van_id', function($query){
            $query->select('van_id')
                ->from('van_queue')
                ->where('has_privilege',1)
                ->orWhereNotNull('queue_number');
        })->where('status','Active')->get();


        return view('van_queue.queue', compact('terminals','queues','vans','destinations','drivers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Terminal $destination, Van $van, Member $member )
    {
        if( is_null(Trip::where('terminal_id',$destination->terminal_id)
            ->where('plate_number',$van->plate_number)
            ->whereNotNull('queue_number')->first()) ){
            $queueNumber = Trip::where('terminal_id',$destination->terminal_id)
                    ->whereNotNull('queue_number')
                    ->count()+1;

            Trip::create([
                'terminal_id' => $destination->terminal_id,
                'plate_number' => $van->plate_number,
                'driver_id' => $member->member_id,
                'remarks' => NULL,
                'queue_number' => $queueNumber
            ]);
            session()->flash('success', 'Van Succesfully Added to the queue');
            return 'success';
        }
        else{
            session()->flash('error', 'Van is already on the Queue');
            return 'Van is already on the Queue';
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRemarks(Trip $trip)
    {

        $this->validate(request(),[
            'value' => [Rule::in('OB','CC','ER', 'NULL')]
        ]);


        if(request('value') === 'NULL'){
            $trip->update([
                'remarks' => NULL
            ]);
        }else{
            $trip->update([
                'remarks' => request('value')
            ]);
        }

        return 'success';
    }

}

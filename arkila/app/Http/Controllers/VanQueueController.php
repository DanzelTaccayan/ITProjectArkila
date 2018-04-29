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
    public function store(Destination $destination, Van $van, Member $member )
    {
        if( is_null(VanQueue::where('destination_id',$destination->destination_id)
            ->where('van_id',$van->van_id)
            ->whereNotNull('queue_number')->first()) )
        {
            $queueNumber = VanQueue::where('destination_id',$destination->destination_id)
                    ->whereNotNull('queue_number')
                    ->count()+1;

            VanQueue::create([
                'destination_id' => $destination->destination_id,
                'van_id' => $van->van_id,
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
    public function updateRemarks(VanQueue $vanOnQueue)
    {

        $this->validate(request(),[
            'value' => [Rule::in('OB','CC','ER', 'NULL')]
        ]);


        if(request('value') === 'NULL'){
            $vanOnQueue->update([
                'remarks' => NULL
            ]);
        }else{
            $vanOnQueue->update([
                'remarks' => request('value')
            ]);
        }

        return 'success';
    }

    public function specialUnitChecker()
    {
        $firstOnQueue = VanQueue::where('queue_number',1)->get();
        $successfullyUpdated = [];
        $pendingUpdate = [];
        $responseArr = [];

        foreach($firstOnQueue as $first)
        {
            if($first->remarks == "ER" || $first->remarks == 'CC')
            {

                $first->update([
                    'queue_number' => null,
                    'has_privilege' => 1
                ]);
                array_push($successfullyUpdated,$first->van_queue_id);

                $queue = VanQueue::whereNotNull('queue_number')->where('destination_id', $first->destination_id)->get();

                foreach($queue as $vanOnQueue)
                {
                    $queueNumber = ($vanOnQueue->queue_number)-1;
                    $vanOnQueue->update([
                        'queue_number'=> $queueNumber
                    ]);
                }

            }elseif($first->remarks =='OB')
            {
                array_push($pendingUpdate,$first->van_queue_id);
            }
        }
        $responseArr[0] = http_build_query($successfullyUpdated);
        $responseArr[1] = http_build_query($pendingUpdate);

        return response()->json($responseArr);
    }

    public function showConfirmationBox($encodedQueue)
    {
        $queue = [];
        parse_str($encodedQueue,$queue);
        if(!is_array($queue))
        {
            abort(404);
        }else
        {
            $vansObjArr = [];
            foreach($queue as $vanOnQueue)
            {
                if($vanObj = VanQueue::find($vanOnQueue))
                {
                    array_push($vansObjArr,$vanObj);
                }else
                {
                    abort(404);
                }
            }
        }
        return view('van_queue.partials.confirmDialogBox',compact('vansObjArr'));
    }

    public function showConfirmationBoxOb($encodedQueue)
    {
        $queue = [];
        parse_str($encodedQueue,$queue);
        if(!is_array($queue))
        {
            abort(404);
        }else
        {
            $vansObjArr = [];
            foreach($queue as $vanOnQueue)
            {
                if($vanObj = VanQueue::find($vanOnQueue))
                {
                    array_push($vansObjArr,$vanObj);
                }else
                {
                    abort(404);
                }
            }
        }
        return view('message.confirm',compact('vansObjArr'));
    }

}

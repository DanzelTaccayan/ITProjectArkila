<?php

namespace App\Http\Controllers;

use App\VanQueue;
use App\Destination;
use App\Member;
use App\Van;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VanQueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mainTerminal = Destination::where('is_main_terminal',1)->first();
        $terminals = Destination::allTerminal()->get();
        $queue = VanQueue::whereNotNull('queue_number')->orderBy('queue_number')->get();
        $drivers = Member::whereNotIn('member_id', function($query)
        {
            $query->select('driver_id')->from('van_queue');
        })->where('status','Active')->get();

        $vans = Van::whereNotIn('van_id', function($query)
        {
            $query->select('van_id')
                ->from('van_queue')
                ->where('has_privilege',1)
                ->orWhereNotNull('queue_number');
        })
            ->where('status','Active')
            ->where('location',$mainTerminal->destination_name)
            ->get();

        return view('van_queue.queue', compact('terminals','queue','vans','destinations','drivers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Destination $destination, Van $van, Member $member )
    {
        // Start transaction!
        DB::beginTransaction();
        try
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
                DB::commit();
                return 'success';
            }
            else
            {
                session()->flash('error', 'Van is already on the Queue');
                return 'Van is already on the Queue';
            }

        }
        catch(\Exception $e)
        {
            DB::rollback();
            dd($e);
            return back()->withErrors('There seems to be a problem. Please try again There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateQueueNumber(VanQueue $vanOnQueue)
    {
        $vansArr = [];
        $queue = VanQueue::whereNotNull('queue_number')->orderBy('queue_number')->get();

        $beingTransferredKey = $vanOnQueue->queue_number;
        $beingReplacedKey = request('new_queue_num');

        $beingTransferredVal = $vanOnQueue->van_queue_id;
        $beingReplacedVal = VanQueue::where('queue_number',request('new_queue_num'))->first()->van_queue_id;

        $vanCount = VanQueue::whereNotNull('queue_number')->count();
        $responseArr = [];
        $this->validate(request(),[
            'value' => 'required|digits_between:1,'.$vanCount,
        ]);

        for($i = 0,$n = 1; $i < count($queue) ; $i++,$n++)
        {
            $vansArr[$n] =  $queue[$i]->van_queue_id;
        }

        $vansArr[$beingReplacedKey] = $beingTransferredVal;


        if($beingTransferredKey > $beingReplacedKey)
        {

            $beingReplacedKey += 1;

            for($i = $beingReplacedKey; $i<= $beingTransferredKey; $i++)
            {
                $beingTransferredVal =  $vansArr[$i];
                $vansArr[$i] = $beingReplacedVal;
                $beingReplacedVal = $beingTransferredVal;
            }

            foreach($vansArr as $queueNum => $vanQueueId)
            {
                $vanQueue = VanQueue::find($vanQueueId);

                $vanQueue->update([
                    'queue_number' => $queueNum
                ]);

                array_push($responseArr,[
                'vanId' => $vanQueue->van_queue_id,
                'queueNumber' => $vanQueue->queue_number
            ]);
            }

        }
        else
        {
            $beingReplacedKey -= 1;

            for($i = $beingReplacedKey; $i>= $beingTransferredKey; $i--)
            {
                $beingTransferredVal = $vansArr[$i];
                $vansArr[$i] = $beingReplacedVal;
                $beingReplacedVal = $beingTransferredVal;
            }

            foreach($vansArr as $queueNum => $vanQueueId)
            {
                $vanQueue = VanQueue::find($vanQueueId);

                $vanQueue->update([
                    'queue_number' => $queueNum
                ]);

                array_push($responseArr,[
                    'vanId' => $vanQueue->van_queue_id,
                    'queueNumber' => $vanQueue->queue_number
                ]);
            }
        }

        return response()->json($responseArr);
    }

    public function updateDestination(VanQueue $vanOnQueue)
    {
        $this->validate(request(),[
            'destination' => 'required|exists:destination,destination_id'
        ]);

        if(request('destination') != $vanOnQueue->destination_id)
        {
            $queueNum = count(VanQueue::where('destination_id',request('destination'))->whereNotNull('queue_number')->get())+1;
            $queue = VanQueue::where('destination_id',$vanOnQueue->destination_id)->whereNotNull('queue_number')->get();

            foreach( $queue as $vanOnQueueObj)
            {
                if($vanOnQueueObj->van_queue_id	 == $vanOnQueueObj->van_queue_id || $vanOnQueueObj->queue_number < $vanOnQueueObj->queue_number )
                {
                    continue;
                }
                else
                {
                    $vanOnQueueObj->update([
                        'queue_number' => ($vanOnQueueObj->queue_number)-1
                    ]);
                }
            }

            $vanOnQueue->update([
                'destination_id' => request('destination'),
                'queue_number' => $queueNum
            ]);
        }
        return 'success';
    }

    public function updateRemarks(VanQueue $vanOnQueue)
    {

        $this->validate(request(),[
            'value' => [Rule::in('OB','CC','ER', 'NULL')]
        ]);


        if(request('remark') === 'NULL'){
            $vanOnQueue->update([
                'remarks' => NULL
            ]);
        }else{
            $vanOnQueue->update([
                'remarks' => request('remark')
            ]);
        }

        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VanQueue $vanqueue)
    {
        // Start transaction!
        DB::beginTransaction();
        try
        {
            if($vanqueue->queue_number)
            {
                $queue = VanQueue::where('destination_id',$vanqueue->destination_id)->get();
                foreach($queue as $vanOnQueueObject)
                {
                    if($vanOnQueueObject->queue_number > $vanqueue->queue_number)
                    {
                        $vanOnQueueObject->update([
                            'queue_number' => $vanOnQueueObject->queue_number-1
                        ]);
                    }
                }
            }

            $vanqueue->delete();
            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
        }

        session()->flash('success', 'Van on Queue Successfully Removed');
        return back();
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

    public function listSpecialUnits(Destination $terminal)
    {
        $queue = $terminal->vanQueue()->where('has_privilege',1)->get();
        return view('trips.partials.listSpecialUnits',compact('queue'));
    }

    public function updateVanQueue()
    {
        $vans = request('vanQueue');

        $queueArr = [];
        if(is_array($vans))
        {
            foreach($vans[0] as $key => $vanInfo)
            {
                if($van = Van::find($vanInfo['vanid']))
                {
                    $van->updateQueue($key);
                }
            }

            $queue = VanQueue::whereNotNull('queue_number')->orderBy('queue_number')->get();

            foreach($queue as $vanOnQueue)
            {
                array_push($queueArr,
                    [
                        'van_queue_id' => $vanOnQueue->van_queue_id,
                        'van_id' => $vanOnQueue->van_id,
                        'queue_number' => $vanOnQueue->queue_number
                    ]);
            }
            return response()->json($queueArr);
        }
        else
        {
            return "Operator Not Found";
        }

    }

    public function putOnDeck(VanQueue $vanOnQueue)
    {
        $queue = VanQueue::where('destination_id',$vanOnQueue->destination_id)->whereNotNull('queue_number')->get();

        foreach($queue as $vanOnQueueObj)
        {
            $newQueueNumber = ($vanOnQueueObj->queue_number)+1;
            $vanOnQueueObj->update([
                'queue_number' => $newQueueNumber
            ]);
        }

        $vanOnQueue->update([
            'queue_number' => 1,
            'remarks' => null,
            'has_privilege' => 0
        ]);

        return back();
    }

    public function changeRemarksOB(VanQueue $vanOnQueue)
    {
        $this->validate(request(),[
            'answer' => [Rule::in(['Yes', 'No'])]
        ]);

        if(request('answer') === 'Yes')
        {
            $queue = VanQueue::where('destination_id',$vanOnQueue->destination_id)->get();

            foreach($queue as $vanOnQueueObj)
            {
                if($vanOnQueueObj->queue_number > $vanOnQueue->queue_number)
                {
                    $vanOnQueueObj->update([
                        'queue_number' => $vanOnQueueObj->queue_number-1
                    ]);
                }
            }

            $vanOnQueue->update([
                'queue_number' => NULL,
                'has_privilege' => 1
            ]);
        }
        else
        {
            $vanOnQueue->update([
                'remarks' => NULL,
            ]);
        }
    }

    public function listQueueNumbers(Destination $terminal)
    {
        $queueArr = [];
        $queue = $terminal->vanQueue()->whereNotNull('queue_number')->get();

        foreach($queue as $vanOnQueueObj){
            array_push($queueArr,[
                'value' =>  $vanOnQueueObj->queue_number,
                'text' => $vanOnQueueObj->queue_number
            ]);
        }
        return $queueArr;
    }
}

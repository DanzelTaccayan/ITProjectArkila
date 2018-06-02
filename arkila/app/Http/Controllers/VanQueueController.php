<?php

namespace App\Http\Controllers;

use App\VanQueue;
use App\Destination;
use App\Member;
use App\Van;
use Illuminate\Http\Request;
use Response;
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
        $terminals = Destination::allTerminal()->get();
        $queue = VanQueue::whereNotNull('queue_number')->orderBy('queue_number')->get();
        $drivers = Member::whereNotIn('member_id', function($query) {
            $query->select('driver_id')->from('van_queue');
        })->where('status','Active')->get();

        $vans = Van::whereNotIn('van_id', function($query) {
            $query->select('van_id')
                ->from('van_queue')
                ->where('has_privilege',1)
                ->orWhereNotNull('queue_number');
        })
            ->where('status','Active')
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
        try {
            if( is_null(VanQueue::where('destination_id',$destination->destination_id)
                ->where('van_id',$van->van_id)
                ->whereNotNull('queue_number')->first())) {
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

                DB::commit();
                return '#queue'. $destination->destination_id;
            } else {
                DB::rollback();
                session()->flash('error', 'Van is already on the Queue');

            }

        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
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
        if(!is_null(request('new_queue_num')) ) {
            // Start transaction!
            DB::beginTransaction();
            try {
                $queue = VanQueue::whereNotNull('queue_number')->where('destination_id', $vanOnQueue->destination_id)->orderBy('queue_number', 'asc')->get();

                //Get the van queue id and the queue number of the being transferred van
                $beingTransferredQueueNumber = $vanOnQueue->queue_number;

                //Get the queue id and the queue number of the being replaced van
                $beingReplacedQueueNumber = request('new_queue_num');

                if ($beingTransferredQueueNumber > $beingReplacedQueueNumber) {
                    //Update the queue number of each van in ascending order
                    for ($i = $beingReplacedQueueNumber - 1; $i < $beingTransferredQueueNumber - 1; $i++) {
                        //Get the queue number of the van after the current van in the array
                        $queue[$i]->update([
                            'queue_number' => $queue[$i + 1]->queue_number
                        ]);
                    }
                    //Give the assigned queue number to the designated van
                    $vanOnQueue->update([
                        'queue_number' => $beingReplacedQueueNumber
                    ]);
                } else {
                    //if the replaced queue number is greater then the transferred then
                    //Update the number of each van in descending order
                    for ($i = $beingReplacedQueueNumber - 1; $i > $beingTransferredQueueNumber-1; $i--) {
                        $queue[$i]->update([
                            'queue_number' => $queue[$i - 1]->queue_number
                        ]);
                    }
                    //Give the assigned queue number to the designated van
                    $vanOnQueue->update([
                        'queue_number' => $beingReplacedQueueNumber
                    ]);
                }
                DB::commit();
                $responseArr = VanQueue::select('van_queue_id as vanQueueId','queue_number as queueNumber')->whereNotNull('queue_number')->where('destination_id', $vanOnQueue->destination_id)->orderBy('queue_number', 'asc')->get();

            } catch (\Exception $e) {
                DB::rollback();
                \Log::info($e);
                return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
            }

            return response()->json($responseArr);
        }
    }

    public function updateDestination(VanQueue $vanOnQueue)
    {
        // Start transaction!
        DB::beginTransaction();
        try {
            $this->validate(request(),[
                'destination' => 'required|exists:destination,destination_id'
            ]);
            $vanQueueArr = [];
            $vanQueueArr['oldQueue'] = [];
            $vanQueueArr['newQueue'] = [];

            if(request('destination') != $vanOnQueue->destination_id)
            {
                $queueNum = count(VanQueue::where('destination_id',request('destination'))->whereNotNull('queue_number')->get())+1;
                $queue = VanQueue::where('destination_id',$vanOnQueue->destination_id)->whereNotNull('queue_number')->get();
                $oldDestinationId = $vanOnQueue->destination_id;
                $newDestinationId = request('destination');

                foreach( $queue as $vanOnQueueObj)
                {
                    if($vanOnQueue->queue_number < $vanOnQueueObj->queue_number )
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

                $oldQueue = VanQueue::where('destination_id',$oldDestinationId)->whereNotNull('queue_number')->orderBy('queue_number','asc')->get();
                $newQueue = VanQueue::where('destination_id',$newDestinationId)->whereNotNull('queue_number')->orderBy('queue_number','asc')->get();

                foreach($oldQueue as $oldVanOnQueue) {
                    array_push($vanQueueArr['oldQueue'], [
                       'vanQueueId' => $oldVanOnQueue->van_queue_id,
                        'queueNumber' => $oldVanOnQueue->queue_number
                    ]);
                }

                foreach($newQueue as $newVanOnQueue) {
                    array_push($vanQueueArr['newQueue'], [
                        'vanQueueId' => $newVanOnQueue->van_queue_id,
                        'queueNumber' => $newVanOnQueue->queue_number
                    ]);
                }

                DB::commit();
                return response()->json($vanQueueArr);
            }
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }
        return 'Destination not Updated';
    }

    public function updateRemarks(VanQueue $vanOnQueue)
    {
        // Start transaction!
        DB::beginTransaction();
        try {

            $this->validate(request(),[
                'value' => [Rule::in('OB','CC','ER', 'NULL')]
            ]);


            if(request('remark') === 'NULL') {
                $vanOnQueue->update([
                    'remarks' => NULL
                ]);
            } else {
                $vanOnQueue->update([
                    'remarks' => request('remark')
                ]);
            }

            DB::commit();
            if(request('fromDepart')) {
                session()->flash('success', $vanOnQueue->van->plate_number.' will remain on deck and its remark has been removed.');
            }
            return 'Successfully updated the remark of van '.$vanOnQueue->van->plate_number;
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }


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
        try {
            if($vanqueue->queue_number) {
                $queue = VanQueue::where('destination_id',$vanqueue->destination_id)->get();
                foreach($queue as $vanOnQueueObject) {
                    if($vanOnQueueObject->queue_number > $vanqueue->queue_number) {
                        $vanOnQueueObject->update([
                            'queue_number' => $vanOnQueueObject->queue_number-1
                        ]);
                    }
                }
            }

            $vanqueue->delete();
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }
        // session()->flash('success', 'Van on Queue Successfully Removed');
        return redirect('/home/vanqueue#queue'. $vanqueue->destination_id)->with('success',  $vanqueue->van->plate_number .' has been successfully removed from the queue.');
    }

    public function specialUnitChecker()
    {
            $firstOnQueue = VanQueue::where('queue_number',1)->get();
            $responseArr = [];

            foreach($firstOnQueue as $first) {
                if ($first->remarks == "ER" || $first->remarks == 'CC') {

                    array_push($responseArr, [
                        'plateNumber' => $first->van->plate_number,
                        'terminal' => $first->destination->destination_name,
                        'remarks' => $first->remarks
                    ]);
                }
            }

            return response()->json($responseArr);
    }

    public function updateVanQueue()
    {
        $vans = request('vanQueue');
        $queueArr = [];
        $number = request('number');
        $destinationId = $number+2;
        // Start transaction!
        DB::beginTransaction();
        try {
            if(is_array($vans) && !is_null($number)) {
                foreach($vans[$number] as $key => $vanInfo) {
                    if($van = Van::find($vanInfo['vanid'])) {
                        $van->updateQueue($key);
                    }
                }

                $queue = VanQueue::whereNotNull('queue_number')->where('destination_id',$destinationId)->orderBy('queue_number','asc')->get();

                foreach($queue as $vanOnQueue) {
                    array_push($queueArr,
                        [
                            'vanQueueId' => $vanOnQueue->van_queue_id,
                            'queueNumber' => $vanOnQueue->queue_number
                        ]);
                }
                DB::commit();
                return response()->json($queueArr);
            } else {
                return "Operator Not Found";
            }

        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }

    }

    public function putOnDeck(VanQueue $vanOnQueue)
    {
        if($vanOnQueue->has_privilege === 1 ) {
            // Start transaction!
            DB::beginTransaction();
            try {
                $queue = VanQueue::where('destination_id',$vanOnQueue->destination_id)->whereNotNull('queue_number')->get();

                foreach($queue as $vanOnQueueObj) {
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

                DB::commit();
            } catch(\Exception $e) {
                DB::rollback();
                return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
            }
            return redirect('/home/vanqueue#queue'. $vanOnQueue->destination_id)->with('success',  $vanOnQueue->van->plate_number .' has been moved on deck.');
        } else {
            return back()->withErrors('Error, The Van is already on deck');
        }
    }

    public function changeRemarksOB(VanQueue $vanOnQueue)
    {
        // Start transaction!
        DB::beginTransaction();
        try {
            $this->validate(request(),[
                'answer' => [Rule::in(['Yes', 'No'])]
            ]);

            if(request('answer') === 'Yes') {
                $queue = VanQueue::where('destination_id',$vanOnQueue->destination_id)->get();

                foreach($queue as $vanOnQueueObj) {
                    if($vanOnQueueObj->queue_number > $vanOnQueue->queue_number) {
                        $vanOnQueueObj->update([
                            'queue_number' => $vanOnQueueObj->queue_number-1
                        ]);
                    }
                }

                $vanOnQueue->update([
                    'queue_number' => NULL,
                    'has_privilege' => 1
                ]);
            } else {
                $vanOnQueue->update([
                    'remarks' => NULL,
                ]);
            }

            DB::commit();

        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }
    }

    public function moveToSpecialUnit(VanQueue $vanOnQueue)
    {
        if($vanOnQueue->has_privilege === 0){
            // Start transaction!
            DB::beginTransaction();
            try {
                $queue = $vanOnQueue->destination->vanQueue()->whereNotNull('queue_number')->get();

                foreach($queue as $onQueue) {
                    if($onQueue->queue_number > $vanOnQueue->queue_number ) {
                        $onQueue->update([
                            'queue_number' => $onQueue->queue_number-1
                        ]);
                    }
                }

                $vanOnQueue->update([
                    'queue_number' => null,
                    'has_privilege' => 1
                ]);
                DB::commit();
                if(request('fromDepart')){
                    session()->flash('success','Successfully moved '.$vanOnQueue->van->plate_number.' into the special unit list.');
                }
                return 'Success';
            } catch(\Exception $e) {
                DB::rollback();
                return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
            }
        } else {
            return back()->withErrors(422,'Error, The Van is already on the special units List');
        }

    }
}

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
                session()->flash('error', 'Van is already on the Queue');
                return 'Van is already on Queue';
            }

        } catch (\Exception $e) {
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
        // Start transaction!
        DB::beginTransaction();
        try {
            $vansArr = [];
            $queue = VanQueue::whereNotNull('queue_number')->orderBy('queue_number')->get();

            $beingTransferredKey = $vanOnQueue->queue_number;
            $beingReplacedKey = request('new_queue_num');

            $beingTransferredVal = $vanOnQueue->van_queue_id;
            $beingReplacedVal = VanQueue::where('queue_number',request('new_queue_num'))->first()->van_queue_id;

            $vanCount = VanQueue::whereNotNull('queue_number')->count();
            $responseArr = [[],'beingReplacedId'=> $beingReplacedVal];

            $this->validate(request(),[
                'new_queue_num' => 'required|digits_between:1,'.$vanCount,
            ]);

            for($i = 0,$n = 1; $i < count($queue) ; $i++,$n++) {
                $vansArr[$n] =  $queue[$i]->van_queue_id;
            }

            $vansArr[$beingReplacedKey] = $beingTransferredVal;


            if($beingTransferredKey > $beingReplacedKey) {

                $beingReplacedKey += 1;

                for($i = $beingReplacedKey; $i<= $beingTransferredKey; $i++) {
                    $beingTransferredVal =  $vansArr[$i];
                    $vansArr[$i] = $beingReplacedVal;
                    $beingReplacedVal = $beingTransferredVal;
                }

                foreach($vansArr as $queueNum => $vanQueueId) {
                    $vanQueue = VanQueue::find($vanQueueId);

                    $vanQueue->update([
                        'queue_number' => $queueNum
                    ]);

                    array_push($responseArr[0],[
                        'vanId' => $vanQueue->van_queue_id,
                        'queueNumber' => $vanQueue->queue_number
                    ]);
                }

            } else {
                $beingReplacedKey -= 1;

                for($i = $beingReplacedKey; $i>= $beingTransferredKey; $i--) {
                    $beingTransferredVal = $vansArr[$i];
                    $vansArr[$i] = $beingReplacedVal;
                    $beingReplacedVal = $beingTransferredVal;
                }

                foreach($vansArr as $queueNum => $vanQueueId) {
                    $vanQueue = VanQueue::find($vanQueueId);

                    $vanQueue->update([
                        'queue_number' => $queueNum
                    ]);

                    array_push($responseArr[0],[
                        'vanId' => $vanQueue->van_queue_id,
                        'queueNumber' => $vanQueue->queue_number
                    ]);
                }
            }

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
        }

        return response()->json($responseArr);
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

            if(request('destination') != $vanOnQueue->destination_id)
            {
                $queueNum = count(VanQueue::where('destination_id',request('destination'))->whereNotNull('queue_number')->get())+1;
                $queue = VanQueue::where('destination_id',$vanOnQueue->destination_id)->whereNotNull('queue_number')->get();
                $vanQueueArr['newDestiQueueCount'] = $queueNum;
                $vanQueueArr['changedOldDestiQueueNumber'] = $vanOnQueue->queue_number;
                $vanQueueArr['oldDestiId'] = $vanOnQueue->destination_id;
                $vanQueueArr['oldDestiQueue'] = [];

                foreach( $queue as $vanOnQueueObj)
                {
                    if($vanOnQueue->queue_number < $vanOnQueueObj->queue_number )
                    {
                        $vanOnQueueObj->update([
                            'queue_number' => ($vanOnQueueObj->queue_number)-1
                        ]);
                        array_push($vanQueueArr['oldDestiQueue'],$vanOnQueueObj->van_queue_id);
                    }

                }

                $vanOnQueue->update([
                    'destination_id' => request('destination'),
                    'queue_number' => $queueNum
                ]);

                $vanQueueArr['oldDestiQueueCount'] = count(VanQueue::where('destination_id',$vanOnQueue->destination_id)->whereNotNull('queue_number')->get());

                DB::commit();
                return response()->json($vanQueueArr);
            }


        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
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
            if(request('fromOb')) {
                session()->flash('success', $vanOnQueue->van->plate_number.' will remain on deck and its remark has been removed.');
            }
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
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
            return back()->withErrors('There seems to be a problem. Please try again There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
        }
        // session()->flash('success', 'Van on Queue Successfully Removed');
        return redirect('/home/vanqueue#queue'. $vanqueue->destination_id)->with('success',  $vanqueue->van->plate_number .' has been successfully removed from the queue.');
    }

    public function specialUnitChecker()
    {
        // Start transaction!
        DB::beginTransaction();
        try {
            $firstOnQueue = VanQueue::where('queue_number',1)->get();
            $successfullyUpdated = [];
            $pendingUpdate = [];
            $responseArr = [];

            foreach($firstOnQueue as $first) {
                if($first->remarks == "ER" || $first->remarks == 'CC') {

                    $first->update([
                        'queue_number' => null,
                        'has_privilege' => 1
                    ]);
                    array_push($successfullyUpdated,$first->van_queue_id);

                    $queue = VanQueue::whereNotNull('queue_number')->where('destination_id', $first->destination_id)->get();

                    foreach($queue as $vanOnQueue) {
                        $queueNumber = ($vanOnQueue->queue_number)-1;
                        $vanOnQueue->update([
                            'queue_number'=> $queueNumber
                        ]);
                    }

                } elseif($first->remarks =='OB') {
                    array_push($pendingUpdate,$first->van_queue_id);
                }
            }
            $responseArr[0] = http_build_query($successfullyUpdated);
            $responseArr[1] = http_build_query($pendingUpdate);
            DB::commit();

            return response()->json($responseArr);
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
        }
    }

    public function showConfirmationBox($encodedQueue)
    {
        $queue = [];
        parse_str($encodedQueue,$queue);
        if(!is_array($queue)) {
            abort(404);
        } else {
            $vansObjArr = [];
            foreach($queue as $vanOnQueue) {
                if($vanObj = VanQueue::find($vanOnQueue)) {
                    array_push($vansObjArr,$vanObj);
                } else {
                    abort(404);
                }
            }
        }
        return view('van_queue.partials.confirmDialog-ER-CC',compact('vansObjArr'));
    }

    public function showConfirmationBoxOb($encodedQueue)
    {
        $queue = [];
        parse_str($encodedQueue,$queue);
        if(!is_array($queue)) {
            abort(404);
        } else {
            $vansObjArr = [];
            foreach($queue as $vanOnQueue) {
                if($vanObj = VanQueue::find($vanOnQueue)) {
                    array_push($vansObjArr,$vanObj);
                } else {
                    abort(404);
                }
            }
        }
        return view('van_queue.partials.confirmDialog-OB',compact('vansObjArr'));
    }

    public function updateVanQueue()
    {
        $vans = request('vanQueue');
        $queueArr = [];
        $number = request('number');

        // Start transaction!
        DB::beginTransaction();
        try {
            if(is_array($vans) && !is_null($number)) {
                foreach($vans[$number] as $key => $vanInfo) {
                    if($van = Van::find($vanInfo['vanid'])) {
                        $van->updateQueue($key);
                    }
                }

                $queue = VanQueue::whereNotNull('queue_number')->orderBy('queue_number')->get();

                foreach($queue as $vanOnQueue) {
                    array_push($queueArr,
                        [
                            'van_queue_id' => $vanOnQueue->van_queue_id,
                            'van_id' => $vanOnQueue->van_id,
                            'queue_number' => $vanOnQueue->queue_number
                        ]);
                }
                DB::commit();
                return response()->json($queueArr);
            } else {
                return "Operator Not Found";
            }

        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
        }

    }

    public function putOnDeck(VanQueue $vanOnQueue)
    {
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
            return back()->withErrors('There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
        }

        return redirect('/home/vanqueue#queue'. $vanOnQueue->destination_id)->with('success',  $vanOnQueue->van->plate_number .' has been moved on deck.');
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
            return back()->withErrors('There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
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
                if(request('fromOb')){
                    session()->flash('success','Successfully moved '.$vanOnQueue->van->plate_number.' into the special unit list.');
                }
                return 'Success';
            } catch(\Exception $e) {
                DB::rollback();
                return back()->withErrors('There seems to be a problem. Please try again There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
            }
        } else {
            abort(422,'Error, The Van is already on the special units List');
        }

    }
}

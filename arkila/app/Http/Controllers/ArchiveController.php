<?php
namespace App\Http\Controllers;
use App\Member;
use App\VanQueue;
use App\Van;
use DB;
use App\Rules\checkOperator;

class ArchiveController extends Controller
{
    public function archive() {
        $operators = Member::allOperators()->where('status','Inactive')->get();
        return view('archive.index', compact('operators'));
    }
    //Operators
    public function showArchivedProfileOperator(Member $archivedOperator)
    {
        return view('archive.operatorArchive',compact('archivedOperator'));
    }

    public function archiveOperator(Member $operator)
    {
        if(count($operator->vanQueue) == 0) {
            // Start transaction!
            DB::beginTransaction();
            try {
                //Count the drivers of the operator and archive them
                if($operator->drivers()->count()) {
                    foreach($operator->drivers as $driver) {
                        $driver->archivedOperator()->attach($operator->member_id);
                        $driver->update([
                            'operator_id' => null
                        ]);
                    }
                }
                //Count the vans of the operator and archive them
                if($operator->van()->count()) {
                    foreach($operator->van as $van) {
                        if(count($operator->vanQueue) > 0) {
                            return back()->withErrors('The operator is a driver on the van queue, please change him as a driver or delete the van on the queue before archiving the operator.');
                        } else if (VanQueue::where('van_id',$operator->van->pluck('van_id'))->get()->count() > 0) {
                            $vans = Van::whereIn('van_id',VanQueue::where('van_id',$operator->van->pluck('van_id'))->get()->pluck('van_id'))
                                ->get()
                                ->pluck('plate_number')
                                ->toArray();
                            return back()->withErrors('The vans ('.implode(" ",$vans).') of the operator are on the queue, remove them first before archiving the operator.');
                        }
                        //archive operator and van
                        $van->archivedMember()->attach($operator->member_id);
                        $van->members()->detach($operator->member_id);
                        //archive the driver and van
                        if($van->driver()->first()) {
                            $van->archivedMember()->attach($van->driver()->first()->member_id);
                            $van->members()->detach($van->driver()->first()->member_id);
                        }
                        $van->update([
                            'status' => 'Inactive'
                        ]);
                    }
                }
                $operator->update([
                    'status' => 'Inactive',
                    'notification' => 'Disable',
                ]);
                DB::commit();
            } catch(\Exception $e) {
                DB::rollback();
                return back()->withErrors('There seems to be a problem. Please try again');
            }
        } else {
            //Throw error message
        }
        return redirect(route('operators.index'));
    }

    public function restoreArchivedOperator(Member $archivedOperator)
    {
        // Start transaction!
        DB::beginTransaction();
        try {
            $archivedOperator->update([
                'status' => 'Active'
            ]);
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again');
        }
        return back();
    }

    //Drivers
    public function archiveDriver(Member $driver)
    {
        // Start transaction!
        DB::beginTransaction();
        try {
            if(count($driver->vanQueue) > 0) {
                return back()->withErrors('The driver is a driver on the van queue, please change him as a driver or delete the van on the queue before archiving the driver.');
            }
            if($driver->operator_id) {
                $driver->archivedOperator()->attach($driver->operator_id);
                $driver->update([
                    'operator_id' => null
                ]);
            }
            if($driver->van()->first()) {
                $driver->archivedVan()->attach($driver->van()->first()->van_id);
                $driver->van()->detach($driver->van()->first()->van_id);
            }
            $driver->update([
                'status' => 'Inactive'
            ]);
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            \Log::info($e);
            return back()->withErrors('There seems to be a problem. Please try again There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
        }
        return back();
    }

    public function restoreArchivedDriver(Member $archivedDriver)
    {
        $this->validate(request(), [
            "operator" => ['bail','nullable','numeric','exists:member,member_id',new checkOperator]
        ]);

        // Start transaction!
        DB::beginTransaction();
        try {
            $archivedDriver->update([
                'status' => 'Active',
                'operator_id' => request('operator')
            ]);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
        }
        return back();
    }

    //Vans
    public function archiveVan(Van $van)
    {
        // Start transaction!
        DB::beginTransaction();
        try
        {
            if($van->vanQueue->count() > 0) {
                return back()->withErrors('The van to be archived is on queue, remove it first from queue before archiving the van');
            }
            //update queue_list if the van is on queue
//            if($vanOnQueue = $van->vanQueue()->whereNotNull('queue_number')->first())
//            {
//                foreach(VanQueue::whereNotNull('queue_number')->where('destination_id',$vanOnQueue->destination_id)->where('queue_number','>',$vanOnQueue->queue_number)->get() as $trip)
//                {
//                    $trip->update([
//                        'queue_number' =>  $trip->queue_number -1
//                    ]);
//                }
//                $vanOnQueue->delete();
//            } elseif($specialVanOnQueue = $van->vanQueue()->whereNull('queue_number')->first()){
//                $specialVanOnQueue->delete();
//            }
            //Archive its operator
            if($van->operator()->first())
            {
                $van->archivedMember()->attach($van->operator()->first()->member_id);
                $van->members()->detach($van->operator()->first()->member_id);
            }
            //Archive its driver
            if($van->driver()->first())
            {
                $van->archivedMember()->attach($van->driver()->first()->member_id);
                $van->members()->detach($van->driver()->first()->member_id);
            }
            //Archive the relationship of the driver and operator, if they exists
            if($van->driver()->first() && $van->operator()->first())
            {
                $van->operator()->first()->archivedDriver()->attach($van->driver()->first()->member_id);
            }
            $van->update([
                'status' => 'Inactive'
            ]);
            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
        }
        return back();
    }

    public function showAllArchivedDriver()
    {
        $archivedDrivers = Member::allDrivers()->where('status','Inactive')->get();
        $activeOperators = Member::allOperators()->where('status', 'Active')->get();
        return view('archive.driverArchive',compact('archivedDrivers','activeOperators'));
    }

    public function showAllArchivedVans()
    {
        $archivedVans = Van::where('status','Inactive')->get();
        $activeOperators = Member::allOperators()->where('status', 'Active')->get();
        return view('archive.vanArchive',compact('archivedVans','activeOperators'));
    }

    public function restoreArchivedVan(Van $archivedVan) {
        $this->validate(request(), [
            "operator" => ['bail','required','numeric','exists:member,member_id',new checkOperator]
        ]);

        // Start transaction!
        DB::beginTransaction();
        try {
            $archivedVan->update([
                'status' => 'Active'
            ]);

            $archivedVan->members()->attach(request('operator'));

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
        }
        return back();
    }
}
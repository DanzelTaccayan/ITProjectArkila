<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

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
        if(is_null($operator->vanQueue)) {
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
                'status' => 'Active',
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
            if($driver->operator_id) {
                $driver->archivedOperator()->attach($driver->operator_id);
                $driver->update([
                    'operator_id' => null
                ]);
            }

            if($driver->van()->first()) {
                $driver->archivedVan()->attach($driver->van()->first()->plate_number);
                $driver->van()->detach($driver->van()->first()->plate_number);
            }

            $driver->update([
                'status' => 'Inactive',
            ]);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
        }

        return back();
    }

    public function restoreArchivedDriver(Member $archivedDriver)
    {
        // Start transaction!
        DB::beginTransaction();
        try {
            $archivedDriver->update([
                'status' => 'Active',
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

            //update queue_list if the van is on queue
            if($vanOnQueue = $van->trips()->whereNotNull('queue_number')->first())
            {
                foreach(Trip::whereNotNull('queue_number')->where('queue_number','>',$vanOnQueue->queue_number)->get() as $trip)
                {
                    $trip->update([
                        'queue_number' =>  $trip->queue_number -1
                    ]);
                }
                $vanOnQueue->delete();
            }

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
                'status' => 'Inactive',
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


}

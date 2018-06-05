<?php

namespace App\Http\Controllers;
use BackupManager\Manager;
use DB;

class RestoreDatabaseController extends Controller{
    protected $manager;


    public function __construct(Manager $manager) {
        $this->manager = $manager;
    }

    public function restoreDatabase() {

        DB::beginTransaction();
        try{
            $this->manager->makeRestore()->run('local', '/database-backup/arkilaBackup.gz', 'mysql', 'gzip');

            DB::commit();
            return back()->with('success','Successfully Restored Database Backup');
        }
        catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }

    }
}

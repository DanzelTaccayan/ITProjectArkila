<?php

namespace App\Http\Controllers;
use BackupManager\Manager;

class RestoreDatabaseController extends Controller{
    protected $manager;


    public function __construct(Manager $manager) {
        $this->manager = $manager;
    }

    public function restoreDatabase() {
        $this->manager->makeRestore()->run('local', '/database-backup/arkilaBackup.gz', 'mysql', 'gzip');

        return back()->with('success','Successfully Restored Database Backup');
    }
}

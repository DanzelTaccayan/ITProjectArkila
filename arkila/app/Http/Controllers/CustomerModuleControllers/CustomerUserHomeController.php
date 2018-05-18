<?php

namespace App\Http\Controllers\CustomerModuleControllers;

use App\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerUserHomeController extends Controller
{
    public function index()
    {
    	$announcements = Announcement::latest()->where('viewer', '=', 'Public')->orWhere('viewer', '=', 'Customer Only')->get();
    	return view('customermodule.index', compact('announcements'));
    }
}

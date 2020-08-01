<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagementController extends Controller
{
    

    public function __construct()
    {
        $this->middleware('can:access_management');
    }

    public function index()
    {
        return view('management');
    }

    //
}

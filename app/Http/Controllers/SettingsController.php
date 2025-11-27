<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    //index action
    public function index()
    {
        return view('settings.index');
    }
}

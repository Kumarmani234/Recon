<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function payuData()
    {
        return view('payu_view');
    }

    public function allAcquirers()
    {
        return view('all_acquirers_view');
    }

    // CosmosController.php
    public function cosmosData()
    {
        return view('cosmos_view');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

class FrontendController extends Controller
{
    public function loadCampaign(Campaign $campaign)
    {
        return view('frontend.index');
    }

    public function placeholder()
    {
        return view('frontend.placeholder');
    }
}

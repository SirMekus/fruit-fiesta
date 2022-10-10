<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Game;

class FrontendController extends Controller
{
    public function loadCampaign(Campaign $campaign)
    {
        if(!Game::whereDate('created_at', carbon()->today())->exists())
        {
            Game::create([
                'campaign_id'=>session('activeCampaign'),
                'account'=>request()->user()->name,
            ]);
        }
        return view('frontend.index');
    }

    public function placeholder()
    {
        return view('frontend.placeholder');
    }
}

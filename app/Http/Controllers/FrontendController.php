<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Game;

class FrontendController extends Controller
{
    public function loadCampaign(Campaign $campaign)
    {
        if(!Game::where('account', request()->user()->name)->whereDate('created_at', carbon()->today())->exists())
        {
            Game::create([
                'campaign_id'=>session('activeCampaign'),
                'account'=>request()->user()->name,
                'revealed_at'=>carbon()->toDateTimeString(),
            ]);
        }
        return view('frontend.index');
    }

    public function placeholder()
    {
        return view('frontend.placeholder');
    }
}

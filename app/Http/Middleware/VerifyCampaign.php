<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Campaign;

class VerifyCampaign
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (session('activeCampaign')) {
            $campaign = Campaign::where('id', session('activeCampaign'))->first();
            //dd($campaign->starts_at->isPast());
            if(!empty($campaign)){
                if(($campaign->starts_at->isFuture())){
                    return redirect('backstage/')->with('status', "This campaign may be played from ".$campaign->starts_at->toFormattedDateString().". Please be patient.");
                }

                if(($campaign->ends_at->isPast())){
                    return redirect('backstage/')->with('status', "This campaign is over. Please create a new campaign to continue.");
                }
            }
            else{
                return redirect('backstage/')->with('status', "Campaign not found");
            }
        }
        else{
            return redirect('backstage/')->with('status', "Unknown operation.");
        }
        
        return $next($request);
    }
}

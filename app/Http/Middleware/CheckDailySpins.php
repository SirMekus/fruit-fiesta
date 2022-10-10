<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Spin;

class CheckDailySpins
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
        if(Spin::whereDate('created_at', carbon()->today())->where('user_id', request()->id)->count() >= (request()->spins ?? 4))
        {
            $msg = "You have used your alloted daily spin for the day. Please try again tomorrow.";

            if(request()->ajax())
            {
                //This is called from the front-end during the course of play.
                return response([
                    'message'=>$msg, 'available'=>false
                ], 403);
            }
            {
                return redirect('backstage/')->with('status', $msg);
            }
        }
        return $next($request);
    }
}

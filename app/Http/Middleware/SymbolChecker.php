<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Symbol;

class SymbolChecker
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
        $count = Symbol::count();
        
        if($count < 6 or $count > 10)
        {
            return redirect('backstage/')->with('status', "There should be a minimum of 6 and maximum of 10 symbols before you launch the game.");
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class SubscriberOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isSubscriber=false;
        if(auth()->check()){                    //check if user is subscriber
            if(auth()->user()->subscriber){
                $isSubscriber=true;
            }
            if(auth()->user()->administrator){
                $isSubscriber=true;
            }
        }
        if(!$isSubscriber){
            //not a Subscriber
            return redirect('/')->with('error', 'Unauthorized Page');

        }
        
        return $next($request);
    }
}

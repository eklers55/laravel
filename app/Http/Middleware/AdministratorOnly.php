<?php

namespace App\Http\Middleware;

use Closure;

class AdministratorOnly
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
        $isAdministrator=false;
        if(auth()->check()){                    //check if user is admin
            if(auth()->user()->administrator){
                $isAdministrator=true;
            }
        }
        if(!$isAdministrator){
            //not a admin
            return redirect('/')->with('error', 'Unauthorized Page');

        }
        
       
        return $next($request);
    }
}

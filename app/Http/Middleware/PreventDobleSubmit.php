<?php

namespace App\Http\Middleware;

use Closure;

class PreventDobleSubmit
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
        $check = \App\SubmitUuid::find($request->uuid);
        if($check === null){
            $submituuid = new \App\SubmitUuid;
            $submituuid->uuid = $request->uuid;
            $submituuid->save(); 
        }
        else{
            return redirect('/');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CanAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$list)
    {
        $auth_role = Auth::user()->role;
        if(!in_array('admin', $list)){
            array_push($list, 'admin');
        }
        $result = in_array($auth_role, $list);
        if(!$result){
            abort(404);
        }
        return $next($request);
    }
}

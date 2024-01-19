<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateUrl
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
         
        $url = $_POST["url"];
        
        if($url !== null && filter_var($url, FILTER_VALIDATE_URL)){
            return response(view('welcome', ["Error" => "Sorry but is not a URL valid"]));
        }
        return $next($request);
    }
}

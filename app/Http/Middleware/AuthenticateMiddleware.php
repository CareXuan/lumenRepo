<?php


namespace App\Http\Middleware;

use Closure;

class AuthenticateMiddleware
{
    public function handle($request,Closure $next){
        if (request()->headers->has('authenticate')){

        }
    }
}
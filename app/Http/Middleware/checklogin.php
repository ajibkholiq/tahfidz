<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checklogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->session()->has('role')){
        // if($request->session()->get('role') == $role){
         return $next($request);}
        // return redirect()->back()->with('fail','kamu bukan bagian dari'.$role);
    
        return redirect('/login')->with('fail','login dulu yah :)');
    }
}

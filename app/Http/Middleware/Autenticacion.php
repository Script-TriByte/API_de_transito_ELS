<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Autenticacion
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
        $urlAPI = config('UrlAPI.urlAPI');

        $tokenHeader = [ "Authorization" => $request->header("Authorization") ];

        $response = Http::withHeaders($tokenHeader)->get($urlAPI . "/api/v3/validar");
        if($response->successful())
            return $next($request);

        return response([ "mensaje" => "Sin autorizacion." ], 403);
    }
}
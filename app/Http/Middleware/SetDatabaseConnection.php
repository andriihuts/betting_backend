<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SetDatabaseConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        
        // Identify the app (use headers, query params, or tokens)
        $appId = $request->header('App-ID'); // Or any other identifier

        if ($appId === 'App1') {
            // Use first database
            Config::set('database.default', 'mysql');
        } elseif ($appId === 'App2') {
            // Use second database
            Config::set('database.default', 'mysql2');
        } else {
            return response()->json(['error' => 'Invalid App-ID'], 403);
        }

        // Optional: reconnect to ensure the new settings take effect
        DB::purge(); 
        DB::reconnect();

        return $next($request);
    }
}

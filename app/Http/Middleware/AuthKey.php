<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if($request->header('APP_KEY') != 'fwdPuYcgxdonAQoncuN8GIuvcOwuiYU8')
        {
            $response = [
                'status' => 400,
                'message' => 'Unauthorized',
            ];

            return response()->json($response, 413);
        }
        else
        {
            return $next($request);
        }
    }
}

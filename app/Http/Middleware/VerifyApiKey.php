<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Log;
use App\Helpers\DateHelper;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header("x-api-key");
        
        if ($apiKey) {

            $env_key = env("API_KEY");


            if (!$env_key) {
                return ResponseHelper::unauthorized("API_KEY not found in .env file");
            }

            if ($apiKey !== env("API_KEY")) {
                Log::error(
                    message: "Unauthorized Request: Invalid API-KEY [Date: [" .
                        DateHelper::now() .
                        "]"
                );
                return ResponseHelper::unauthorized("Invalid API_KEY");
            }
        } else {
            return ResponseHelper::unauthorized("API_KEY not found");
        }
        return $next($request);
    }
}

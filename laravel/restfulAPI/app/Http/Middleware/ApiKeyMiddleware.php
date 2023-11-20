<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class ApiKeyMiddleware
{
    public function handle($request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');
        $userId = $request->route('id'); // Assuming the user ID is part of the route parameters

        $user = User::where('api_key', $apiKey)->first();

        if (!$apiKey || !$user || $user->id !== $userId) {
            return response()->json(['error' => 'Unauthorized: API key does not match user ID'], 401);
        }

        return $next($request);
    }
}

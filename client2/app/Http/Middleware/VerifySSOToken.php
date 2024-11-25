<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class VerifySSOToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization') ?: session('token');

        if (!$token) {
            return redirect('/login');
        }

        try {
            $http = new Client();
            $response = $http->get('http://127.0.0.1:8000/api/user', [
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                ],
            ]);

            $user = json_decode((string) $response->getBody(), true);
            session(['user' => $user]);

        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Invalid or expired token.');
        }

        return $next($request);
    }
}

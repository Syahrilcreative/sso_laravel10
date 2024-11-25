<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class EnsureSSOAuth
{
    private $ssoServerUrl = 'http://127.0.0.1:8000/api'; // URL server .

    public function handle(Request $request, Closure $next)
    {
        if (!session('token')) {
            $token = $request->query('token');
            if (!$token) {
                return redirect('/login');
            }
            try {
                $http = new Client();
                $response = $http->get("{$this->ssoServerUrl}/user", [
                    'headers' => [
                        'Authorization' => "Bearer {$token}",
                    ],
                ]);

                if ($response->getStatusCode() === 200) {
                    $user = json_decode((string) $response->getBody(), true);
                    session([
                        'token' => $token,
                        'user' => $user,
                    ]);
                } else {
                    return redirect('/login');
                }
            } catch (\Exception $e) {
                return redirect('/login')->withErrors(['error' => 'Invalid token or server error.']);
            }
        }
        return $next($request);
    }
}

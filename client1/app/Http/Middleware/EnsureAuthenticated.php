<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class EnsureAuthenticated
{
    private $ssoServerUrl = 'http://127.0.0.1:8000/api';

    public function handle(Request $request, Closure $next)
    {
        $token = session('token');

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

            $user = json_decode((string) $response->getBody(), true);
            session(['user' => $user]);
        } catch (\Exception $e) {
            session()->forget(['token', 'user']); // Hapus session jika token tidak sama
            return redirect('/login');
        }
        return $next($request);
    }
}


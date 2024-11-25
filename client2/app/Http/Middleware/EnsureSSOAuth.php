<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class EnsureSSOAuth
{
    private $ssoServerUrl = 'http://127.0.0.1:8000/api'; // URL server SSO Anda.

    public function handle(Request $request, Closure $next)
    {
        if (!session('token')) {
            $token = $request->query('token');
            if (!$token) {
                return redirect('/login');
            }
            // Check token ke server apakah sama?
            try {
                $http = new Client();
                $response = $http->get("{$this->ssoServerUrl}/user", [
                    'headers' => [
                        'Authorization' => "Bearer {$token}",
                    ],
                ]);

                if ($response->getStatusCode() === 200) {
                    $user = json_decode((string) $response->getBody(), true);
                    // Simpan token session
                    session([
                        'token' => $token,
                        'user' => $user,
                    ]);
                    // kalau sukses, langsung masuk ke URL tanpa token
                    $cleanUrl = $request->url(); // Menghapus variabel di atas biar kgk panjang
                    return redirect($cleanUrl);
                } else {
                    return redirect('/login'); // Jika  gagal,  maka redirect ke login
                }
            } catch (\Exception $e) {
                return redirect('/login')->withErrors(['error' => 'Invalid token or server error.']);
            }
        }
        return $next($request);
    }
}


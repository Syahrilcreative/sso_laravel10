<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
class SSOController extends Controller
{
    private $ssoServerUrl = 'http://127.0.0.1:8000/api';
    public function showLoginForm()
    {
        return view('sso.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $http = new Client();
        try {
            $response = $http->post("{$this->ssoServerUrl}/login", [
                'form_params' => [
                    'email' => $request->email,
                    'password' => $request->password,
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                return redirect()->back()->withErrors(['error' => 'Invalid credentials or server error.']);
            }

            $data = json_decode((string) $response->getBody(), true);
            // ini untuk simpan session dan token di user ya
            session([
                'token' => $data['token'],
                'user' => $data['user'],
            ]);
            return redirect('/dashboard');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Invalid credentials or server error.']);
        }
    }


    public function logout()
    {
        $token = session('token');

        if ($token) {
            $http = new Client();
            try {
                $http->post("{$this->ssoServerUrl}/logout", [
                    'headers' => [
                        'Authorization' => "Bearer {$token}",
                    ],
                ]);
            } catch (\Exception $e) {
                // Abaikan saja yah
            }
        }
        session()->forget(['token', 'user']);
        return redirect('/login');
    }

    public function dashboard()
    {
        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }
        return view('sso.dashboard', compact('user'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    protected $client;
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiBaseUrl = "http://localhost:8001/api";
    }

    public function loginForm()
    {
        return view('login.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        try {
            $response = $this->client->post("{$this->apiBaseUrl}/login", [
                'json' => [
                    'email' => $request->email,
                    'password' => $request->password,
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            if (!isset($result['access_token'])) {
                return back()->withErrors(['email' => 'Invalid credentials']);
            }

            Session::put('access_token', $result['access_token']);
            return redirect()->intended('/products');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return back()->withErrors(['email' => 'Login failed. Please try again.']);
        }
    }

    public function logout()
    {
        Session::forget('access_token');
        return redirect('/login');
    }
}

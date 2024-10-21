<?php

namespace App\Http\Controllers;

use App\Models\UserTechnical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function formLogin()
    {
        return view('user-technicals.auth.login');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username or Email is required.',
            'password.required' => 'Password is required.'
        ]);

        $credentials = [
            'password' => $request->password,
        ];

        // Determine if the input is an email or username
        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $request->username;
        } else {
            $credentials['username'] = $request->username;
        }

        // Attempt to log the user in
        if (Auth::guard('user-technical')->attempt($credentials)) {
            return redirect()->route('user-technical.dashboard');
        }

        // If authentication fails, redirect back with input and error message
        return redirect()->back()->withInput($request->only('username'))
            ->withErrors(['username' => 'Please check your credentials.']);
    }

    public function logout()
    {
        Auth::guard('user-technical')->logout();
        return redirect()->route('user-technical.form-login');
    }
}

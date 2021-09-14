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
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->username; //the input field has name='username' in form
        $password = $request->password; //the input field has name='password' in form

        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            //user sent their email 
            Auth::guard('user-technical')->attempt(['email' => $username, 'password' => $password]);
        } else {
            //they sent their username instead 
            Auth::guard('user-technical')->attempt(['username' => $username, 'password' => $password]);
        }

        //was any of those correct ?
        if (Auth::guard('user-technical')->check()) {
            //send them where they are going 
            return redirect()->route('user-technical.dashboard');
        }

        //Nope, something wrong during authentication 
        return redirect()->back()->withErrors([
            'username' => 'Please, check your credentials'
        ]);
    }

    public function logout()
    {
        if (Auth::guard('user-technical')->check()) {
            Auth::guard('user-technical')->logout();
        }

        return redirect()->route('user-technical.form-login');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha'
        ], [
            'email.required' => 'Email tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'captcha.required' => 'Captcha tidak boleh kosong',
            'captcha.captcha' => 'Captcha tidak cocok'
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // dd('sukses');
            return redirect('/dashboard');
        } else {
            return back()->with('error', 'Email atau password salah');
        }
    }

    public function username()
    {
        return 'username';
    }

    protected function validateLogin(Request $request)
    {
    }
}

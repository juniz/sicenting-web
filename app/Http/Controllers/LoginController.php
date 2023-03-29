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
            $this->username() => 'required|string',
            'password' => 'required|string',
        ],[
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
        ]);
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // dd('sukses');
            return redirect('/dashboard');
        }else{
            return back()->with('error', 'Username atau password salah');
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

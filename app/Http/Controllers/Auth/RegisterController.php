<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        auth()->login($user);

        return redirect()->to('/');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }
}

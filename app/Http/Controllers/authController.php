<?php

namespace App\Http\Controllers;



use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class authController extends Controller
{
    public function register()
    {
        return view('auth/register');
    }

    public function registerSimpan(Request $request)
    {
        Validator::make($request->all(), [

            'nama' => 'required|unique:users|min:3|max:35',
            'userid' => [
                'required',
                'string',
                'min:7',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[0-9]/',      // must contain at least one digit
            ],
            'password' => [
                'required',
                'string',
                'min:8',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[.@$!%*#?&]/', // must contain a special character

            ],
            'level' => 'required'

        ])->validate();

        User::create([
            'nama' => $request->nama,
            'userid' => $request->userid,
            'password' => $request->password,
            'level' => $request->level
        ]);

        return redirect()->route('register')->with('success', 'Register Success! ');
    }

    public function login()
    {
        return view('auth/login');
    }

    public function loginAksi(Request $request)
    {
        validator::make($request->all(), [
            'userid' => 'required',
            'password' => 'required'
        ])->validate();

        if (!Auth::attempt($request->only('userid', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'userid' => trans('auth.failed')
            ]);
        }
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}

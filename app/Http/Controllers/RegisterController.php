<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Modificar el username para evitar duplicados
        $request->request->add(['username' => Str::slug(strtolower($request->username))]);

        // Validacion
        $request->validate([
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:5'
        ]);

        // Crea el usuario
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        // Autenticar usuario
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
        }

        return redirect()->route('posts.index', [
            'user' => Auth::user(),
        ]);
    }
}

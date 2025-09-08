<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        $passwordChanged = false;
        $request->request->add(['username' => Str::slug(strtolower($request->username))]);

        $request->validate([
            'username' => ['required', 'unique:users,username,' . Auth::user()->id, 'min:3', 'max:20', 'not_in:editar-perfil,admin,administrador,root,perfil'],
            'email' => ['required', 'unique:users,email,' . Auth::user()->id, 'email', 'max:60'],
            'actual_password' => 'required|current_password',
        ]);

        // Obtenemos el usuario autenticado
        $usuario = User::find(Auth::user()->id);

        /* Comprobamos si la contraseña actual coincide */
        if (!Hash::check($request->actual_password, Auth::user()->password)) {
            return back()->withErrors('actual_password', 'La contraseña actual no coincide');
        }

        /* Si hay nueva contraseña, la validamos y la actualizamos */
        if ($request->password) {
            $request->validate([
                'password' => ['required', 'confirmed', 'min:5'],
            ]);

            $usuario->password = bcrypt($request->password);
            $passwordChanged = true;
        }

        /* Almacenamos la imagen si viene en el request */
        if ($request->imagen) {
            /* Comprobamos si existe ya una imagen y la borramos */
            if (Auth::user()->imagen) {
                $imagenPath = public_path('perfiles') . '/' . Auth::user()->imagen;
                if (file_exists($imagenPath)) {
                    unlink($imagenPath);
                }
            }

            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            // Creamos el elemento de la imagen y lo adaptamos al tamaño que queremos
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);

            // Almacenamos la imagen en el servidor
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }


        // Actualizamos información
        $usuario->username = $request->username;
        $usuario->email = $request->email;
        $usuario->imagen = $nombreImagen ?? Auth::user()->imagen ?? null;

        // Guardar los cambios
        $usuario->save();

        /* Si la contraseña ha cambiado, cerramos sesión y redirigimos al login */
        if ($passwordChanged) {
            Auth::logout();
            return redirect()->route('login');
        }

        return redirect()->route('posts.index', $usuario->username)->with('message', 'Usuario actualizado correctamente');
    }

    public function autocompletar(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->limit(10) // Limita el número de resultados para mejorar el rendimiento
            ->get();

        return response()->json($users);
    }
}

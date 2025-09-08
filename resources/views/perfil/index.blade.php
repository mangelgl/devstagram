@extends('layouts.app')

@section('titulo')
    Editando el perfil de: {{ Auth::user()->username }}
@endsection

@section('contenido')
    <div class="md:flex md:justify-center flex flex-col items-center">
        <div class="md:w-1/2 p-6">
            <a href="{{ url()->previous() }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="gray"
                    class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
        </div>
        <div class="md:w-1/2 bg-white shadow p-6 rounded-md">
            <form action="{{ route('perfil.store') }}" method="POST" enctype="multipart/form-data" class="mt-10 md:mt-0">
                @csrf
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">Nombre de usuario</label>
                    <input id="username" name="username" type="text" placeholder="Nombre de usuario"
                        class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror"
                        value="{{ old('username') ?? Auth::user()->username }}" />
                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">Email</label>
                    <input id="email" name="email" type="text" placeholder="Correo electrónico"
                        class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                        value="{{ old('email') ?? Auth::user()->email }}" />
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="actual_password" class="mb-2 block uppercase text-gray-500 font-bold">Contraseña
                        actual</label>
                    <input id="actual_password" name="actual_password" type="password" placeholder="Contraseña actual"
                        class="border p-3 w-full rounded-lg @error('actual_password') border-red-500 @enderror" />
                    @error('actual_password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">Nueva contraseña</label>
                    <input id="password" name="password" type="password" placeholder="Nueva contraseña"
                        class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror" />
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="password_confirmation" class="mb-2 block uppercase text-gray-500 font-bold">Repite tu
                        contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        placeholder="Repite tu contraseña" class="border p-3 w-full rounded-lg" />
                </div>

                <div class="mb-5">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold">Imagen de perfil</label>
                    <input id="imagen" name="imagen" type="file" class="border p-3 w-full rounded-lg" />
                </div>

                <input type="submit" value="Guardar cambios"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />
            </form>
        </div>

    </div>
@endsection

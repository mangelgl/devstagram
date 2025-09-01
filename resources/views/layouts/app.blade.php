<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Devstagram - @yield('titulo')</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <header class="p-5 border-b bg-white shadow">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-black"><a href="{{ route('principal') }}">Devstagram</a></h1>

            @auth
                <nav aria-label="Authenticated users menu" class="flex gap-2 items-center">
                    <a class="font-bold uppercase text-gray-600 text-sm" href="{{ route('posts.index', ['user' => Auth::user()]) }}">
                        {{ auth()->user()->username }}
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="font-bold uppercase text-gray-600 text-sm cursor-pointer">Cerrar sesión</button>
                    </form>
                </nav>
            @endauth
            
            @guest
                <nav aria-label="Guests menu" class="flex gap-2 items-center">
                    <a class="font-bold uppercase text-gray-600 text-sm" href="{{ route('login') }}">Login</a>
                    <a class="font-bold uppercase text-gray-600 text-sm" href="{{ route('register') }}">Crear cuenta</a>
                </nav>
            @endguest
        </div>
    </header>

    <main class="container mx-auto mt-10 text-center">
        <h2 class="font-black text-center text-2xl mb-10" >@yield('titulo')</h2>
        @yield('contenido')
    </main>

    <footer class="mt-10 text-center p-5 text-gray-500 font-bold uppercase">
        Devstagram - Todos los derechos reservados {{ now()->year }}
    </footer>
</body>

</html>

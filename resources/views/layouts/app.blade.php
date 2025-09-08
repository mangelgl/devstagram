<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>Devstagram - @yield('titulo')</title>
    {{-- La directiva stack permite agregar estilos css para ciertos
    elementos y que no se cargen en todas las páginas --}}
    @stack('styles')
    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles()
</head>

<body class="bg-gray-100">
    <header class="p-5 border-b bg-white shadow">
        <div class="container mx-auto flex justify-between items-center">
            {{-- Título --}}
            <h1 class="text-3xl font-black"><a href="{{ route('home') }}">Devstagram</a></h1>

            {{-- Búsqueda --}}
            <div class="sm:hidden lg:block mx-auto relative w-4/12">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput" name="query" placeholder="Busca"
                        class="block w-full rounded-xl bg-gray-200 p-2.5 pl-10 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div id="resultados"
                    class="absolute z-10 w-full mt-2 hidden rounded-xl border border-gray-300 bg-gray-400 p-3 shadow-lg overflow-hidden">
                </div>
            </div>

            <script>
                document.getElementById('searchInput').addEventListener('keyup', function() {
                    let query = this.value;
                    let resultsContainer = document.getElementById('resultados');

                    if (query.length > 3) {
                        // Muestra el contenedor de resultados
                        resultsContainer.classList.remove('hidden');

                        fetch(`{{ route('perfil.buscar') }}?query=${query}`)
                            .then(response => response.json())
                            .then(users => {
                                let html = '';
                                if (users.length > 0) {
                                    users.forEach(user => {
                                        // Construye el HTML dinámicamente con los datos del usuario
                                        let userImage = user.imagen ? `/perfiles/${user.imagen}` :
                                            '/img/usuario.svg';
                                        let profileUrl = `/${user.username}`;

                                        html += `
                                        <a href="${profileUrl}">
                                            <div class="w-full bg-gray-400 hover:bg-gray-300 hover:cursor-pointer flex justify-between items-center rounded-md">
                                                <div class="flex justify-center items-center ">
                                                    <div class="p-3">
                                                        <img src="${userImage}" alt="Foto de perfil" width="30" height="30">
                                                    </div>
                                                    <div class="flex flex-col justify-center items-start p-3">
                                                        <p class="font-bold text-gray-700">${user.username}</p>
                                                        <p class="text-sm text-gray-700">${user.name}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>`;
                                    });
                                } else {
                                    html = '<p class="text-center text-gray-500">No se encontraron resultados.</p>';
                                }
                                resultsContainer.innerHTML = html;
                            })
                            .catch(error => console.error('Error:', error));

                    } else {
                        // Oculta el contenedor si no hay suficiente texto
                        resultsContainer.classList.add('hidden');
                        resultsContainer.innerHTML = '';
                    }
                });
                /* Oculta los resultados si el usuario hace click fuera  */
                document.addEventListener('click', function(event) {
                    let searchContainer = document.getElementById('resultados');
                    if (!searchContainer.contains(event.target)) {
                        document.getElementById('resultados').classList.add('hidden');
                    }
                });

                document.addEventListener('DOMContentLoaded', (event) => {
                    // Limpia el campo de búsqueda
                    document.getElementById('searchInput').value = '';

                    // Opcional: Oculta y limpia el contenedor de resultados
                    let resultsContainer = document.getElementById('resultados');
                    resultsContainer.innerHTML = '';
                    resultsContainer.classList.add('hidden');
                });
            </script>
            {{-- Navegación --}}
            <div>
                @auth
                    <nav aria-label="Authenticated users menu" class="flex gap-2 items-center">
                        {{-- Crear publicaciones --}}
                        <a href="{{ route('posts.create') }}"
                            class="flex items-center gap-2 bg-white border p-2 text-gray-600 rounded text-sm uppercase font-bold cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                <path fill-rule="evenodd"
                                    d="M1 8a2 2 0 0 1 2-2h.93a2 2 0 0 0 1.664-.89l.812-1.22A2 2 0 0 1 8.07 3h3.86a2 2 0 0 1 1.664.89l.812 1.22A2 2 0 0 0 16.07 6H17a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8Zm13.5 3a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM10 14a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                    clip-rule="evenodd" />
                            </svg>
                            Crear
                        </a>
                        {{-- Nombre de usuario --}}
                        <a class="flex items-center font-bold uppercase text-gray-600 text-sm"
                            href="{{ route('posts.index', ['user' => Auth::user()]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <span>{{ auth()->user()->username }}</span>
                        </a>
                        {{-- Cerrar sesión --}}
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex items-center font-bold uppercase text-gray-600 text-sm cursor-pointer">Cerrar
                                sesión</button>
                        </form>
                    </nav>
                @endauth

                @guest
                    <nav aria-label="Guests menu" class="flex gap-2 items-center">
                        <a class="font-bold uppercase text-gray-600 text-sm" href="{{ route('login') }}">Login</a>
                        <a class="font-bold uppercase text-gray-600 text-sm" href="{{ route('register') }}">Crear
                            cuenta</a>
                    </nav>
                @endguest
            </div>
    </header>

    <main class="container mx-auto mt-10 text-center">
        <h2 class="font-black text-center text-2xl mb-10">@yield('titulo')</h2>
        @yield('contenido')
    </main>

    <footer class="mt-10 text-center p-5 text-gray-500 font-bold uppercase">
        Devstagram - Todos los derechos reservados {{ now()->year }}
    </footer>
    @livewireScripts()
</body>

</html>

@extends('layouts.app')

@section('titulo')
    Perfil: {{ $user->username }}
@endsection

@section('contenido')
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            <div class="w-8/12 lg:w-6/12 px-5">
                <img src="{{ $user->id === Auth::user()->id ? asset('perfiles/' . $user->imagen) : asset('img/usuario.svg') }}"
                    alt="Perfil usuario">
            </div>
            <div class="md:w-8/12 lg:w-6/12 px-5 flex flex-col items-center md:justify-center md:items-start py-10 md:py-10">
                <div class="flex items-center gap-3">
                    <p class="text-gray-700 text-2xl">{{ $user->name }}</p>
                </div>

                <p class="text-gray-800 text-sm mb-3 font-bold mt-5">
                    {{ $user->followers->count() }}
                    <span class="font-normal">@choice('seguidor|seguidores', $user->followers->count())</span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{ $user->followings->count() }}
                    <span class="font-normal">seguidos</span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{ $user->posts->count() }}
                    <span class="font-normal">Posts</span>
                </p>

                @auth
                    <div class="flex items-center gap-2 my-5">
                        {{-- Editar perfil --}}
                        @if ($user->id === Auth::user()->id)
                            <button
                                class="bg-blue-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer">
                                <a href="{{ route('perfil.index') }}" class="flex items-center gap-2">Editar</a>
                            </button>
                        @else
                            {{-- Seguir perfil --}}
                            @if (!$user->following(Auth::user()))
                                <form action="{{ route('users.follow', $user) }}" method="POST"
                                    class="flex items-center gap-2">
                                    @csrf
                                    <input type="submit" value="Seguir"
                                        class="bg-blue-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer">
                                </form>
                            @else
                                {{-- Dejar de seguir perfil --}}
                                <form action="{{ route('users.unfollow', $user) }}" method="POST"
                                    class="flex items-center gap-2">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Dejar de seguir"
                                        class="bg-red-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer">
                                </form>
                            @endif
                        @endif
                    </div>
                @endauth
            </div>

        </div>
    </div>

    <section class="container mx-auto mt-10">
        <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>

        @if ($posts->count())
            {{-- Posts --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 my-10">
                @foreach ($posts as $post)
                    <div class="">
                        <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
                            <img src="{{ asset('uploads/' . $post->imagen) }}" alt="{{ $post->titulo }}">
                        </a>
                    </div>
                @endforeach
            </div>

            <div>
                {{ $posts->links() }}
            </div>
        @else
            <p class="text-gray-600 uppercase text-sm text-center font-bold">No hay posts</p>
        @endif
    </section>
@endsection

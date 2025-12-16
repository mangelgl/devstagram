@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')
    <div class="container mx-auto md:flex flex flex-col items-center">
        <livewire:back-button :width="'w-full'" />
        <div class="container mx-auto md:flex">
            <div class="md:w-1/2">
                <img src="{{ asset('img/posts') . '/' . $post->imagen }}" alt="{{ $post->titulo }}">
                <div class="p-3 flex items-center gap-3">
                    @auth
                        <livewire:like-post :post="$post" />
                    @endauth

                </div>

                <div>
                    <a href="{{ route('posts.index', $post->user->username) }}"
                        class="font-bold">{{ $post->user->username }}</a>
                    <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                    <p class="mt-5">{{ $post->descripcion }}</p>
                </div>

                @auth
                    @if ($post->user_id === Auth::user()->id)
                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <input type="submit" value="Eliminar publicación"
                                class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer">
                        </form>
                    @endif
                @endauth
            </div>
            <div class="md:w-1/2 p-5">
                <div class="shadow bg-white p-5 mb-5 rounded-md">
                    <p class="text-xl font-bold text-center mb-4 uppercase">Comentarios</p>

                    @if (session('message'))
                        <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                            {{ session('message') }}
                        </div>
                    @endif

                    @auth
                        {{-- Formulario para agregar un comentario --}}
                        <form action="{{ route('comentarios.store', ['user' => $user, 'post' => $post]) }}" method="POST">
                            @csrf
                            <div class="mb-5">
                                <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold text-left">Agrega un
                                    comentario</label>
                                <textarea id="comentario" name="comentario" placeholder="Escriba aquí su comentario"
                                    class="border p-3 w-full rounded-lg @error('comentario') border-red-500 @enderror">{{ old('comentario') }}</textarea>
                                @error('comentario')
                                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <input type="submit" value="Enviar comentario"
                                class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />
                        </form>
                    @endauth

                    <div class="mb-5 mt-10 max-h-96 overflow-y-scroll">
                        @if ($post->comentarios->count())
                            @foreach ($post->comentarios as $comentario)
                                <div class="p-5 border-gray-300 border-b text-left">
                                    <a href="{{ route('posts.index', ['user' => $comentario->user->username]) }}"
                                        class="font-bold">{{ $comentario->user->username }}</a>
                                    <p>{{ $comentario->comentario }}</p>
                                    <p class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p>
                                </div>
                            @endforeach
                        @else
                            <p class="p-10 text-center">No hay comentarios aún</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

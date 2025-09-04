@extends('layouts.app')

@section('titulo')
    Página principal
@endsection

@section('contenido')
    <section class="container grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 my-10">
        @if ($posts->count())
            @foreach ($posts as $post)
                {{-- Posts --}}
                <div class="">
                    <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
                        <img src="{{ asset('uploads/' . $post->imagen) }}" alt="{{ $post->titulo }}">
                    </a>
                </div>
            @endforeach

            <div>
                {{ $posts->links() }}
            </div>
        @else
            <p>No hay posts, sigue a alguien para mostrar sus posts</p>
        @endif
    </section>
@endsection

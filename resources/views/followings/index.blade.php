@extends('layouts.app')

@section('titulo')
    Lista de seguidos
@endsection

@section('contenido')
    <div class="md:flex md:justify-center flex flex-col items-center">
        <livewire:back-button />
        <livewire:users-list :contacts="$followings" />
    </div>
@endsection

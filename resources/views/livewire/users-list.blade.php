<div class="md:w-1/2 bg-white shadow p-6 rounded-md">
    @forelse ($this->contacts as $follower)
        {{-- Contact card --}}
        <div class="md:w-full bg-gray-300 flex justify-between items-center mb-5 rounded-md">
            <div class="flex justify-center items-center">
                <div class="p-3">
                    <img src="{{ $follower->imagen ? asset('perfiles/' . $follower->imagen) : asset('img/usuario.svg') }}"
                        alt="Foto de perfil" width="60" height="60">
                </div>
                <div class="flex flex-col justify-center items-start p-3">
                    <p class="font-bold text-gray-600"><a
                            href="{{ route('posts.index', $follower) }}">{{ $follower->username }}</a></p>
                    <p class="text-sm text-gray-600">{{ $follower->name }}</p>
                </div>

            </div>
            <div class="p-3">
                {{-- Seguir perfil --}}
                @if (!$follower->following(Auth::user()))
                    <button wire:click="follow({{ $follower->id }})"
                        class="bg-blue-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer">
                        Seguir
                    </button>
                @else
                    {{-- Dejar de seguir perfil --}}
                    <button wire:click="unfollow({{ $follower->id }})"
                        class="bg-red-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer">
                        Dejar de seguir
                    </button>
                @endif
            </div>
        </div>
    @empty
        <p class="text-gray-600 font-bold uppercase">No se han encontrado usuarios.</p>
    @endforelse
</div>

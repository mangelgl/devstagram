<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UsersList extends Component
{
    public $contacts;

    public function mount($contacts)
    {
        $this->contacts = $contacts;
    }

    /** No se recarga el DOM al seguir o dejar de seguir para mostrar el usuario en la lista */
    public function follow(User $user)
    {
        $user->followers()->attach(Auth::user()->id);
    }

    public function unfollow(User $user)
    {
        $user->followers()->detach(Auth::user()->id);
    }

    public function render()
    {
        return view('livewire.users-list');
    }
}

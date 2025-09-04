<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikePost extends Component
{
    public $post;
    public $isLiked;

    public function mount($post)
    {
        $this->isLiked = $post->checkLike(Auth::user());
    }

    public function like()
    {
        // Eliminamos el like
        if ($this->post->checkLike(Auth::user())) {
            $this->post->likes()->where('post_id', $this->post->id)->delete();
            $this->isLiked = false;
        } else {
            // Damos like
            $this->post->likes()->create([
                'user_id' => Auth::user()->id,
            ]);
            $this->isLiked = true;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowingController extends Controller
{
    public function index(User $user)
    {
        $followings = $user->followings()->get();

        return view('followings.index', [
            'user' => $user,
            'followings' => $followings,
        ]);
    }
}

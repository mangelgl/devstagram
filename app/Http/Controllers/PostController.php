<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class PostController extends Controller
{
    //
    public function index()
    {
        return view('dashboard');
    }
}

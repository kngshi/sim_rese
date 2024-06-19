<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUser()
    {
        $user= User::select('id')->get();

        return view('mypage', compact('user'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function profile()
    {
        return response()->json([
            'data' => [
                'user' => Auth::user(),
                'profile' => User::find(Auth::user()->id)->profiles,
            ],
        ], 200);
    }
}

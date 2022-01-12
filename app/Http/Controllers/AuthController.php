<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Promise\Create;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * Register a new User in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // dd($request);
        $credential = $request->validate([
            // 'first_name' => ['required', 'string', 'max:255'],
            // 'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
            // 'picture_path' => ['required',],
        ]);
        
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($credential['password']),
            // 'email_verified_at' => Carbon::now()->toDateTimeString(),
        ]);
        $request->session()->put('auth.password_confirmed_at', time());
        
        event(new Registered($user));
        // $user->save();

        // Storage::disk('public')->put('/images/', $request->file('picture_path'));

        // $profile = Profile::create([
        //     'first_name' => $request->first_name,
        //     'last_name' => $request->last_name,
        //     'picture_path' => $request->file('picture_path')->hashName(),
        //     'user_id' => $user->user_id,
        // ]);

        // $shop = Shop::Create([
        //     'name' => $request->first_name . $request->last_name . 'shop',
        //     'user_id' => $user->user_id,
        // ]);


        Auth::login($user);

        return response()->json([
            'msg' => 'Vous avez été enregistrer.',
        ], 200);
    }
    /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        //
    }
    /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        //
    }
}

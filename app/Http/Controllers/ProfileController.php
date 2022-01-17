<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Return the user and their profile informations
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return response()->json([
            'data' => [
                'user' => Auth::user(),
                'profile' => User::find(Auth::user()->id)->profiles,
            ],
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(UpdateProfileRequest $request)
    {
        $request->validated();
        $profile = Profile::find(auth()->user()->id);
        $shop = Shop::where('user_id', Auth::user()->id)->first();

        // dd($request);

        if ($profile->picture_path != 'default.jpg' || $profile->picture_path != 'default.png') {
            Storage::disk('public')->delete('/images/' . $profile->picture_path);
        }
        Storage::disk('public')->put('images', $request->file('picture_path'));

        $shop->name = $request->first_name . ' ' . $request->last_name . ' shop';
        $shop->save();
        $user = User::find(Auth::user()->id);
        $user->email = $request->email;
        $user->save();
        $profile->first_name =  $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->picture_path = $request->file('picture_path')->hashName();
        $profile->user_id = auth()->user()->id;
        $profile->save();

        return response()->json('success', 200);
    }
}

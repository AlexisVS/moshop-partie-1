<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => Shop::all(),
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show($shopId)
    {
        $shop = Shop::find($shopId);
        $data = [
            'shop' => $shop,
            'products' => $shop->articles
        ];
        return response()->json($data, 200);
    }

    public function showMyShop () {
        $shop = Shop::where('user_id', auth()->user()->id)->first();
        $data = [
            'shop' => $shop,
            'products' => $shop->articles
        ];
        return response()->json($data, 200);
    }
}

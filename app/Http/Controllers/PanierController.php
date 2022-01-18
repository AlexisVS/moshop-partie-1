<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Http\Requests\StorePanierRequest;
use App\Http\Requests\UpdatePanierRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanierController extends Controller
{

    /**
     * Return the card of the user
     * @return \Illuminate\Http\Response
     */
    public function showCart()
    {
    }

    // /** 
    //  * Clean up the user Cart by comparison between the first and last item
    //  *  and store the article in the Panier table
    //  * @param \Illuminate\Http\Request $request
    //  */
    // public function addToCart(Request $request)
    // {
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paniers = Auth::user()->paniers;
        foreach ($paniers as $panier) {
            $panier->article_id = Article::find($panier->article_id);
        }
        return response()->json($paniers, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePanierRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePanierRequest $request)
    {
        $request->validated();
        
        $user = Auth::user();
        $paniers = $user->paniers;

        if (isset($paniers) == true && $paniers->count() > 0) {
            // Clean 
            foreach ($paniers as $panier) {
                if ($panier->shop_id != $request->shop_id) {
                    $panier->delete();
                }
            }
            // replace if exist
            foreach ($paniers as $panier) {
                if ($panier->article_id == $request->article_id) {
                    $panier->quantity = $request->quantity;
                    $panier->save();
                }
            }
        };

        // si article est pas contenu dans paniers
        $condition = Panier::all()->where('user_id', $user->id)->where('article_id', $request->article_id)->count();
        if ($condition == 0) {
            Panier::create([
                'quantity' => $request->quantity,
                'user_id' => $user->id,
                'article_id' => $request->article_id,
                'shop_id' => $request->shop_id,
            ]);
        }

        // return response()->json([$storePanier, $request], 200,);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePanierRequest  $request
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePanierRequest $request, Panier $panier)
    {
        $request->validated();
        
        $panier->quantity = $request->quantity;
        $panier->save();

        return response()->json([
            'message' => 'Success',
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Panier $panier)
    {
        Panier::destroy($panier);

        return response()->json([
            'message' => 'Success delete',
        ], 200);
    }
}

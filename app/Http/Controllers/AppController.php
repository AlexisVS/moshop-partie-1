<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Commande;
use App\Models\Panier;
use App\Models\Profile;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    /**
     * Return default view for the application
     * @return \Illuminate\View
     */
    public function index()
    {
        return view('app');
    }



    /**
     * Return the card of the user
     * @return \Illuminate\Http\Response
     */
    public function showCart()
    {
        $paniers = Auth::user()->paniers;
        $articlesPanier = Article::findMany($paniers->pluck('article_id')->toArray());

        foreach ($paniers as $panier) {
            $panier->article_id = Article::find($panier->article_id);
        }
        return response()->json($paniers, 200);
    }

    /** 
     * Clean up the user Cart by comparison between the first and last item
     *  and store the article in the Panier table
     * @param \Illuminate\Http\Request $request
     */
    public function addToCart(Request $request)
    {
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
     * Clean up the user card by comparison between articles->shop_id of the first and the last
     * Reduce the quantity of @model Article with their correspond paniers product_id and quantity
     * Store all Carts id to @model Command->articles_id in JSON format 
     * @return Illuminate\Http\Response
     */
    public function buy()
    {
        $user = Auth::user();
        $paniers = $user->paniers;

        if ($paniers->count() == 0) {
            return response()->json([
                "message" => "Your cart is empty",
                "errors" => [
                    'ouais' => "c'est cool",
                ]
            ], 266);
        }

        $firstPanier = $paniers->first();
        $lastPanier = $paniers->last();

        if ($paniers->count() > 1) {
            foreach ($paniers as $panier) {
                if ($panier->shop_id != $lastPanier->shop_id) {
                    $panier->delete();
                }
            }
        };

        foreach ($paniers as $panier) {
            if ($panier->quantity > 0) {
                $article = Article::find($panier->article_id);
                $article->quantity = $article->quantity - $panier->quantity;
                $article->save();
            }
        }


        // prendre tous les articles de tous les panier et leur quantité
        $articles = collect(Article::find($paniers->pluck('article_id')->toArray()));
        $articles_id = $articles->pluck('id');
        // et multiplier le prix * la quantité et additionner
        $totals = collect([]);
        foreach ($paniers as $key => $value) {
            $totals->push([$articles[$key]->price * $value['quantity']]);
        }

        $commande = Commande::create([
            'user_id' => $user->id,
            'price' => $totals->flatten()->sum(),
            'json_arr_articles_id' => $articles->pluck('id')->toJson(),
        ]);

        Panier::destroy($paniers);

        return response()->json('bien jouer ma gueule', 200);
    }
}

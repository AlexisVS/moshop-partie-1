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

<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $request->validated();
        $shopId = Shop::where('user_id', auth()->user()->id)->first()->id;

        Storage::disk('public')->put('images', $request->file('cover_path'));

        Article::create([
            'name' => $request->name,
            'description' => $request->description,
            'cover_path' => $request->file('cover_path')->hashName(),
            'price' => $request->price,
            'quantity' => $request->quantity,
            'shop_id' => $shopId,
        ]);

        return response()->json([
            'success' => 'Tu es trop fort',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
        $data = [
            'article' => $article,
            'shop' => Shop::find($article->shop_id),
        ];
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        if (Shop::where('user_id', auth()->user()->id)->first()->id == $article->shop_id) {
            return response()->json([
                'data' => $article,
            ], 200);
        }

        return response()->json([
            'error' => 'Y a eu un problème chef',
        ], 502);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, $id)
    {
        $article = Article::find($id);
        $request->validated();
        // if ($article->cover_path != 'default.jpg' || $article->cover_path != 'default.png') {
        //     Storage::disk('public')->delete('/images/' . $article->cover_path);
        // }
        // Storage::disk('public')->put('images', $request->file('cover_path'));

        $article->name = $request->name;
        $article->description = $request->description;
        // $article->cover_path = $request->file('cover_path')->hashName();
        $article->price = $request->price;
        $article->quantity = $request->quantity;
        $article->save();

        return response()->json([
            'success' => 'Tu es trop fort',
        ], 200);
    }

    /**
     * Update image of article
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateImageArticle(Request $request, $articleId)
    {
        $article = Article::find($articleId);

        if ($article->cover_path != 'default.jpg' || $article->cover_path != 'default.png') {
            Storage::disk('public')->delete('/images/' . $article->cover_path);
        }

        Storage::disk('public')->put('images', $request->file('cover_path'));

        $article->cover_path = $request->file('cover_path')->hashName();
        $article->save();

        return response()->json('success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->shop_id = null;
        $article->save();

        return response()->json([
            'message' => 'Article successfully removed'
        ], 200);
    }
}

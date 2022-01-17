<?php

namespace App\Http\Resources;

use App\Http\Resources\Article as ResourcesArticle;
use App\Models\Article;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Commande extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'price' => $this->price,
            'json_arr_articles_id' => ResourcesArticle::collection(Article::where('id', $this->json_arr_articles_id)),
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Panier;
use App\Models\Profile;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->has(
                Profile::factory()
                    ->state(function (array $attributes, User $user) {
                        return [
                            'user_id' => $user->id,
                        ];
                    }),
                'profiles'
            )
            ->has(
                Shop::factory()
                    ->has(
                        Article::factory()
                            ->state(function (array $attributes, Shop $shop) {
                                return ['shop_id' => $shop->id];
                            })
                            ->count(20),
                        'articles'
                    )
                    ->state(function (array $attributes, User $user) {
                        return [
                            'user_id' => $user->id,
                            'name' => $user->profiles->first_name . ' ' . $user->profiles->last_name . ' shop',
                        ];
                    })
                    ->count(1),
                'shops'
            )
            ->count(2000)
            ->create();
    }
}

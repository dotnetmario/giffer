<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->createCategories(30);
        $this->createTags(50);

        $role = null;
        for ($i = 0; $i < 100; $i++) {
            if ($i == 0)
                $role = 'admin';
            else
                $role = 'user';

            $user = $this->createUser($role);

            $geolocation = $user->geolocations()->create([
                'ip' => fake()->ipv4,
                'country_code' => fake()->countryCode,
                'country_name' => fake()->country,
                'city' => fake()->city,
                'zip_code' => fake()->postcode,
                'time_zone' => fake()->timezone,
                'latitude' => fake()->latitude,
                'longitude' => fake()->longitude
            ]);

            for($j = 0; $j < rand(50, 100); $j++){
                $meme = $user->memes()->create([
                    'title' => fake()->sentence(rand(5, 20)),
                    'body' => fake()->sentence(rand(15, 35)),
                    'file' => fake()->imageUrl(600, 900, 'cats')
                ]);

                $meme->tags()->sync(
                    \App\Models\Tag::inRandomOrder()->limit(rand(5, 20))->pluck('id')->toArray()
                );

                $meme->categories()->sync(
                    \App\Models\Category::inRandomOrder()->limit(rand(5, 20))->pluck('id')->toArray()
                );
            }
        }

        $all_the_memes = \App\Models\Meme::all();

        foreach($all_the_memes as $meme){
            for($h = 0; $h < rand(10, 50); $h++){
                $comment = \App\Models\Comment::create([
                    'user_id' => \App\Models\User::inRandomOrder()->first()->id,
                    'meme_id' => $meme->id,
                    'content' => fake()->sentence(rand(10, 30)),
                ]);
            }
    
            for($h = 0; $h < rand(10, 50); $h++){
                $like = \App\Models\Like::create([
                    'user_id' => \App\Models\User::inRandomOrder()->first()->id,
                    'meme_id' => $meme->id,
                ]);
            }
        }
    }

    private function createUser($role)
    {
        return \App\Models\User::create([
            'role' => $role,
            'username' => fake()->userName,
            'name' => fake()->firstNameMale . ' ' . fake()->lastName,
            'email' => fake()->safeEmail,
            'password' => Hash::make('123456789')
        ]);
    }

    private function createTags($i = 10)
    {
        $tags = [];
        for($i; $i > 0; $i--){
            $tags[] = \App\Models\Tag::create([
                'name' => fake()->domainWord
            ]);
        }

        return $tags;
    }

    private function createCategories($i = 10)
    {
        $cats = [];
        for($i; $i > 0; $i--){
            $cats[] = \App\Models\Category::create([
                'name' => fake()->domainWord
            ]);
        }

        return $cats;
    }
}

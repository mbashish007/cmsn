<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Repo;
use App\Tag;
use App\File;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Daenerys Targaryen',
            'username' => 'Khalessi',
            'email' => 'danytargaryen@gmail.com',
            'password' => Hash::make('wcuRThdga8MxG9R'),
            'role' => 'admin',
        ]);

        $user2 = User::create([
            'name' => 'Jon Snow',
            'username' => 'King1nNorth',
            'email' => 'jonsnow@gmail.com',
            'password' => Hash::make('JonSnow#321'),
        ]);

        $tag1 = Tag::create([
            'name' => 'Queen' 
        ]);
        $tag2 = Tag::create([
            'name' => 'King' 
        ]);
        $tag3 = Tag::create([
            'name' => 'Stormborn' 
        ]);
        $tag4 = Tag::create([
            'name' => 'Queen of the Andals, the Rhoynar, and the First Men' 
        ]);
        $tag5 = Tag::create([
            'name' => 'Protector of the Seven Kingdoms' 
        ]);
        $tag6 = Tag::create([
            'name' => 'Khaleesi of the Great Grass Sea' 
        ]);
        $tag7 = Tag::create([
            'name' => 'Breaker of Chains' 
        ]);
        $tag8 = Tag::create([
            'name' => 'Mother Of Dragons' 
        ]);
        $tag9 = Tag::create([
            'name' => 'The Unburnt' 
        ]);
        $tag10 = Tag::create([
            'name' => 'Game Of Thrones' 
        ]);
        
        $repo1 = $user1->repos()->create([
                'name' => 'Dany',
                'slug' => 'dany-Khalessi'
            ]);

        $repo2 = $user1->repos()->create([
                'name' => 'Drogon',
                'slug' => 'drogon-khalessi'
            ]);

        $repo3 = $user2->repos()->create([
                'name' => 'Castle Black',
                'slug' => 'castle-black-king1nnorth'
            ]);
        
        $repo1->tags()->attach([1,3,4,5,6,7,8,9,10]);
        $repo2->tags()->attach([10]);
        $repo3->tags()->attach([1,10]);
        
        $user1->image()->create([
            'image' => 'images/5ZheLBHF6Ja4zksFT2khFmUAqMCm4jpktDBlM4Ad.jpeg'
        ]);

        $user2->image()->create([
            'image' => 'images/W3p9Ud9cpilNzrtBIWpxb5gj5wxcBwXebpDytmJL.jpeg'
        ]);

        $repo1->files()->create([
            'name' => 'AGameOfThrones.pdf',
            'file' => 'files/uXe37UX7OLNX7YEOo8Slvb6ifIhT21HfKfuS788x.pdf' 
            ]);
    }
}

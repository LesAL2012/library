<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $numberUsers = env('NUMBER_USERS');
        \App\Models\User::factory($numberUsers)->create();

        \App\Models\Writer::factory(env('NUMBER_WRITERS'))->create();

        $tagArr = eval("return " . env('TAGS') . ";");
        foreach ($tagArr as $tag) {
            $tag = str_replace("_", " ", $tag);
            \App\Models\Tag::factory()->create(['name' => $tag]);
        }

        $categoryArr = eval("return " . env('CATEGORY') . ";");
        foreach ($categoryArr as $category) {
            $category = str_replace("_", " ", $category);
            \App\Models\Category::factory()->create(['name' => $category]);
        }

        $genreArr = eval("return " . env('GENRES') . ";");
        $idGenre = 0;
        foreach ($genreArr as $genre => $type_genres) {
            $idGenre++;
            $genre = str_replace("_", " ", $genre);
            \App\Models\Genre::factory()->create(['name' => $genre]);

            foreach ($type_genres as $type_genre) {
                $type_genre = str_replace("_", " ", $type_genre);
                \App\Models\TypeGenre::factory()->create([
                    'name' => $type_genre,
                    'genre_id' => $idGenre,
                ]);
            }
        }

        $numberBooks = env('NUMBER_BOOKS');
        \App\Models\Book::factory($numberBooks)->create();

        $numberTags = count($tagArr);
        for ($book = 1; $book <= $numberBooks; $book++) {

            $arrTagsId = array();
            $countTagsOnPage = env('NUMBER_TAGS');
            for ($i = 1; $i <= $countTagsOnPage; $i++) {
                $arrTagsId[$i] = rand(1, $numberTags);
            }
            $arrTagsId = array_unique($arrTagsId);

            foreach ($arrTagsId as $tagId) {
                \App\Models\BookTag::factory()->create([
                    'book_id' => $book,
                    'tag_id' => $tagId,
                ]);
            }
        }

        /* $maxLikesOneUser = env('MAX_LIKE_BOOK_ONE_USER');
        for ($book = 1; $book <= $numberBooks; $book++) {

            $arrUserId = array();
            for ($i = 1; $i <= $maxLikesOneUser; $i++) {
                $arrUserId[$i] = rand(1, $numberUsers);
            }
            $arrUserId = array_unique($arrUserId);

            foreach($arrUserId as $userId){
                \App\Models\BookUserLike::factory()->create([
                    'book_id' => $book,
                    'user_id' => $userId,
                ]);
            }
        } */

        $book_user_like = array();
        for ($book = 1; $book <= $numberBooks; $book++) {

            $likes = rand(1, env('MAX_BOOK_USER_LIKES'));

            $users = array();
            for ($user = 1; $user <= $likes; $user++) {
                array_push($users, rand(1, $numberUsers));
            }
            $users = array_unique($users);

            $book_user_like[rand(1, $numberBooks)] = $users;
        }
        foreach ($book_user_like as $book => $users) {
            foreach ($users as $user) {
                \App\Models\BookUserLike::factory()->create([
                    'book_id' => $book,
                    'user_id' => $user,
                ]);
            }
        }

        $this->call(LaratrustSeeder::class);


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Intervention\Image\Facades\Image;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>    */


    public function definition(): array
    {
        $img_files = array();
        $files = scandir(storage_path(env('DIR_IMG_FACTORY')));
        $link_read = str_replace('/app/public', 'storage', env('DIR_IMG_FACTORY'));
        $link_save = str_replace('/app/public', 'storage', env('DIR_IMG_FACTORY_MIN'));
        $extentions = ['JPG', 'PNG', 'GIF', 'BMP'];
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                ini_set('memory_limit', '512M');
                $file_parts = explode('.', $file);
                $file_ext = $file_parts[count($file_parts) - 1];
                if (in_array(strtoupper($file_ext), $extentions)) {
                    //echo $link_read . $file . ' - ' . strlen($file) . '---------------<br>';
                    array_push($img_files, $file);
                    Image::make($link_read . $file)->fit(165, 220)->save($link_save . $file);
                } else {
                    echo $link_read . $file . ' - ' . strlen($file) . '<br>';
                    unlink($link_read . $file);
                }
            }
        }

        $genreArr = eval("return " . env('GENRES') . ";");
        $idTypeGenre = 0;
        foreach ($genreArr as $genre => $type_genres) {
            foreach ($type_genres as $type_genre) {
                $idTypeGenre++;
            }
        }

        $categoryArr = eval("return " . env('CATEGORY') . ";");

        return [
            'name' => substr($this->faker->sentence(3), 0, -1),

            'writer_id' => rand(1, env('NUMBER_WRITERS')),

            'category_id' => rand(1, count($categoryArr)),

            'type_genre_id' => rand(1, $idTypeGenre),

            'image' => $img_files[rand(0, count($img_files)-1)],
            'description' => $this->faker->paragraph(1),
            'description_more' => $this->faker->paragraph(6),
            'year' =>  rand(1960, date("Y")),
            'amount' =>  rand(1, 20),
        ];
    }
}

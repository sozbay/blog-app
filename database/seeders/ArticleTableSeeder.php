<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run(Faker\Generator $faker)
    {
        Article::truncate();
        for($i=0;$i<30;$i++){
            $author=$faker->sentence(2);
            $title=$faker->sentence(3);
            $description=$faker->sentence(30);
             Article::create([
                'author'=>$author,
                'title'=>$title,
                'description'=>$description,
                'category_id'=>random_int(1,5),
                'show_count'=>0
            ]);
        }
    }
}

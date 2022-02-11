<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->truncate();
        $categories=['Bilgisayar','Teknoloji','Yazılım','Spor','Siyaset'];
        foreach ($categories as $category){
            DB::table('category')->insert([
                'category_name'=>$category
            ]);
        }

    }
}

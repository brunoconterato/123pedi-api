<?php

use Drinking\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class)->create([
            'name' => 'Alcoólicos',
        ]);

        factory(Category::class)->create([
            'name' => 'Não Alcoólicos',
        ]);

        factory(Category::class)->create([
            'name' => 'Cigarros',
        ]);

        factory(Category::class)->create([
            'name' => 'Outros',
        ]);
    }
}
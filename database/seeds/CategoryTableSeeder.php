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
            'name' => 'alcoolicos',
        ]);

        factory(Category::class)->create([
            'name' => 'nao_alcoolicos',
        ]);

        factory(Category::class)->create([
            'name' => 'cigarros',
        ]);

        factory(Category::class)->create([
            'name' => 'outros',
        ]);
    }
}
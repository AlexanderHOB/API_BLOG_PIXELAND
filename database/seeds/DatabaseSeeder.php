<?php

use App\Post;
use App\User;
use App\Action;
use App\Category;
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
        // $this->call(UserSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Category::truncate();
        Post::truncate();
        Action::truncate();
        DB::table('category_post')->truncate();
        //cancelar eventos
        User::flushEventListeners();
        Category::flushEventListeners();
        Post::flushEventListeners();
        Action::flushEventListeners();

        $quantityUsers=1000;
        $quantityCategories=10;
        $quantityPosts=500;
        $quantityActions = 1500;

        factory(User::class,$quantityUsers)->create();
        factory(Category::class,$quantityCategories)->create();
        factory(Post::class,$quantityPosts)->create()->each(
            function ($post){
                $categorias = Category::all()->random(mt_rand(1,5))->pluck('id');
                $post->categories()->attach($categorias);
            }
        );
        factory(Action::class,$quantityActions)->create();

    }
}

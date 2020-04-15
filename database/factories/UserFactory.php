<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use App\Action;
use App\Category;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'lastname'=>$faker->lastname,
        'username'=>$faker->unique()->username,
        'email' => $faker->unique()->safeEmail,
        'image' => $faker->randomElement(['1.jpg','2.jpg','3.jpg']),
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'verified'=>$vericado=$faker->randomElement([User::USER_VERIFIED,User::USER_NO_VERIFIED]),
        'verification_token'=>$vericado == User::USER_VERIFIED ? null : User::generateVerificationToken(),
        'admin'=> $faker->randomElement([User::USER_ADMIN,User::USER_NO_ADMIN])
    ];
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description'   =>  $faker->paragraph(1),
    ];
});


$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'brief' => $faker->paragraph(1),
        'content' => $faker->paragraph(10),
        'status' => $faker->randomElement([Post::POST_AVAILABLE,Post::POST_NO_AVAILABLE]),
        'media' => $faker->randomElement(['1.jpg','2.jpg','3.jpg']),
        'writter_id'=> User::all()->random()->id ,
    ];
});

$factory->define(Action::class, function (Faker $faker) {
    $REACTION = ['i like it','funny','i love it','surprised','annoying','sad',];
    return [
        'type' => $tipo=$faker->randomElement([Action::ACTION_REACTION,Action::ACTION_SCORE,Action::ACTION_COMMENT]),
        'content' => $tipo == Action::ACTION_REACTION ? $faker->randomElement(['i like it','funny','i love it','surprised','annoying','sad',]) : ($tipo == Action::ACTION_SCORE ? $faker->randomElement(['1','2','3','4','5']) : $faker->paragraph(1)),
        'post_id'=> Post::all()->random()->id,
        'reader_id'=> User::all()->random()->id,
    ];
});
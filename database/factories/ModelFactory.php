<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Booklist::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->name,
		'user_id' => factory(App\User::class)->create()->id
	];
});

$factory->define(App\Book::class, function (Faker\Generator $faker) {
	return [
			'title' => $faker->name,
			'booklist_id' => factory(App\Booklist::class)->create(
					[ 'user_id' => factory(App\User::class)->create()->id ]
			 )->id,
			'author' => $faker->name,
			'publication_date' => $faker->date(),
			'description' => $faker->realText(),
			'rating' => $faker->randomFloat(1, 0, 5)
	];
});
<?php

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

$factory->define(App\Models\User\User::class, function (Faker $faker) {

    return [
        'phone' => strval(rand(100000000, 199999999) * 100 + rand(0, 99)),
        'username' => $faker->unique()->firstName,
        'password' => $faker->word,
        'verification' => rand(0, 3),
        'money' => rand(10, 1000) * 10,
        'realname' => $faker->name,
    ];
});

$factory->define(App\Models\Item\Item::class, function (Faker $faker) {

    return [
        'item_userid' => \App\Models\User\User::all()->random()->id,
        'item_gameid' => \App\Models\Item\Game::all()->random()->id,
        'item_cataid' => rand(1, 3),
        'item_status' => rand(1, 3),
        'item_coverurl' => $faker->imageUrl(),
        'item_weburl' => $faker->url,
        'item_title' => $faker->streetAddress,
        'item_description' => $faker->text,
        'item_players' => function () use ($faker) {
            $str = '';
            for ($i = 0; $i < rand(3, 7); $i++) {
                $str .= $faker->unique()->name . ', ';
            }
            return $str;
        },
        'item_note' => $faker->sentence,
        'item_text' => $faker->randomHtml(),
        'item_fake' => rand(0, 1),
        'item_interval' => rand(1, 5),
        'ended_at' => function () {
            return \Carbon\Carbon::now()->addDays(7);
        },
    ];
});

$factory->define(App\Models\Item\ItemOption::class, function (Faker $faker) {

    return [
        'itemid' => \App\Models\Item\Item::all()->random()->id,
        'item_option_title' => $faker->streetAddress,
        'item_option_cost' => rand(1, 10) * 10,
    ];
});

$factory->define(App\Models\Item\ItemAnnouncement::class, function (Faker $faker) {

    $item = \App\Models\Item\Item::all()->random();
    return [
        'itemid' => $item->id,
        'userid' => $item->user->id,
        'item_anno_content' => $faker->sentence,
        'item_anno_private' => rand(0, 1),
    ];
});


$factory->define(App\Models\Conduction\Banner::class, function (Faker $faker) {

    return [
        'banner_title' => $faker->sentence,
        'banner_description' => $faker->text,
        'banner_coverurl' => $faker->imageUrl(),
        'banner_weburl' => $faker->url,
        'banner_place' => rand(1, 4),
    ];
});

$factory->define(App\Models\Conduction\Recommand::class, function (Faker $faker) {

    return [
        'recommand_itemid' => \App\Models\Item\Item::all()->random()->id,
        'recommand_weburl' => $faker->imageUrl(),
    ];
});


